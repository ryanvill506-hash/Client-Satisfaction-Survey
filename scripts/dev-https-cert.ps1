$ErrorActionPreference = 'Stop'

$certificateDirectory = Join-Path $PSScriptRoot '..\storage\app\dev-https'
$certificateDirectory = [System.IO.Path]::GetFullPath($certificateDirectory)
$certificatePath = Join-Path $certificateDirectory 'localhost.cer'
$pfxPath = Join-Path $certificateDirectory 'localhost.pfx'

New-Item -ItemType Directory -Path $certificateDirectory -Force | Out-Null

$certificate = Get-ChildItem Cert:\CurrentUser\My |
    Where-Object {
        $_.DnsNameList.Unicode -contains 'localhost' -and
        $_.NotAfter -gt (Get-Date) -and
        $_.HasPrivateKey -and
        $_.FriendlyName -eq 'Client Satisfaction Survey Local HTTPS'
    } |
    Sort-Object NotAfter -Descending |
    Select-Object -First 1

if (-not $certificate) {
    $certificate = New-SelfSignedCertificate `
        -DnsName 'localhost' `
        -CertStoreLocation 'Cert:\CurrentUser\My' `
        -FriendlyName 'Client Satisfaction Survey Local HTTPS' `
        -NotAfter (Get-Date).AddYears(2) `
        -KeyExportPolicy Exportable `
        -KeyAlgorithm RSA `
        -KeyLength 2048 `
        -HashAlgorithm SHA256 `
        -Type SSLServerAuthentication
}

Export-Certificate -Cert $certificate -FilePath $certificatePath -Force | Out-Null

$trustedCertificate = Get-ChildItem Cert:\CurrentUser\Root |
    Where-Object { $_.Thumbprint -eq $certificate.Thumbprint } |
    Select-Object -First 1

if (-not $trustedCertificate) {
    $publicCertificate = [System.Security.Cryptography.X509Certificates.X509Certificate2]::new($certificatePath)
    $rootStore = New-Object System.Security.Cryptography.X509Certificates.X509Store -ArgumentList 'Root', 'CurrentUser'

    try {
        $rootStore.Open([System.Security.Cryptography.X509Certificates.OpenFlags]::ReadWrite)
        $rootStore.Add($publicCertificate)
    }
    finally {
        $rootStore.Close()
        $publicCertificate.Dispose()
    }
}

$randomBytes = New-Object byte[] 32
$randomGenerator = [System.Security.Cryptography.RandomNumberGenerator]::Create()
$randomGenerator.GetBytes($randomBytes)
$pfxPassword = [Convert]::ToBase64String($randomBytes)
$securePfxPassword = ConvertTo-SecureString -String $pfxPassword -AsPlainText -Force

Export-PfxCertificate `
    -Cert $certificate `
    -FilePath $pfxPath `
    -Password $securePfxPassword `
    -Force | Out-Null

Write-Output $pfxPassword
