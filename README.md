# Citizen's Charter Client Satisfaction Measurement (CSM) System

An official, responsive web application built with **Laravel 12/13** for administering the **Citizen's Charter Client Satisfaction Survey**, fully compliant with the standards of the Anti-Red Tape Authority (ARTA) under **Republic Act No. 11032** (*Ease of Doing Business and Efficient Government Service Delivery Act*) and the **Data Privacy Act of 2012 (R.A. 10173)**.

---

## 🌟 Key Features

1. **Clear Instructions & Guidelines**:
   - Built-in collapsible instruction banner explaining:
     - The purpose of the Citizen's Charter satisfaction survey.
     - What the Citizen's Charter is (procedure, timeline, requirements, fees).
     - Rating guide (5 = Strongly Agree, 4 = Agree, 3 = Neutral, 2 = Disagree, 1 = Strongly Disagree, N/A).
     - Strict Data Privacy Act compliance assurance.
2. **Standard 4-Part Survey Questionnaire**:
   - **Part I: Client & Transaction Demographics**: Client Type (Citizen, Business, Government), Date, Sex, Age Bracket, Region, Office/Division Transacted, and Service Availed.
   - **Part II: Citizen's Charter (CC) Awareness & Visibility**:
     - **CC1**: Awareness of the Citizen's Charter (4 standard choices).
     - **CC2**: Visibility of the Citizen's Charter (Easy to see, Difficult, Not visible, N/A).
     - **CC3**: Helpfulness of the Citizen's Charter (Helped very much, Somewhat helped, Did not help, N/A).
     - *Interactive Logic*: If the respondent answers option 4 in CC1 ("Do not know what a Citizen's Charter is"), CC2 and CC3 automatically adapt to "N/A" with an explanatory notice.
   - **Part III: Service Quality Dimensions (SQD0 to SQD8)**:
     - **SQD0**: Overall Satisfaction (Core metric)
     - **SQD1**: Responsiveness (Reasonable transaction time)
     - **SQD2**: Reliability (Followed requirements and steps)
     - **SQD3**: Access & Facilities (Convenient steps and payment)
     - **SQD4**: Communication (Information readily available)
     - **SQD5**: Costs (Acceptable fees, no unauthorized charges)
     - **SQD6**: Integrity (Fair and equal treatment)
     - **SQD7**: Assurance (Courteous and helpful staff)
     - **SQD8**: Outcome (Received service requested or clear explanation)
     - Interactive emoji-based Likert cards (😡 1 to 😃 5, plus ⚪ N/A).
   - **Part IV: Client Suggestions & Contact Details**:
     - Open feedback / commendations textarea.
     - Optional respondent details (Name, Contact Number, Email).
     - Mandatory Data Privacy Consent acknowledgement.
3. **Automated Reference Tracking**:
   - Each submission generates a unique tracking reference (e.g. `CSM-20261006-XXXXXX`) with copy-to-clipboard and print options.
4. **Admin Analytics & Management Dashboard (`/admin/surveys`)**:
   - **Key Performance Indicators (KPIs)**: Total responses, Citizen's Charter Awareness Rate (%), Overall Satisfaction Rate (%), and Mean Overall Score out of 5.0.
   - **Service Quality Dimensions Breakdown**: Real-time mean scores and percentage satisfied per dimension.
   - **Demographic Distribution**: Breakdown between Citizen, Business, and Government respondents.
   - **Search & Filtering**: Filter by reference code, respondent name, office transacted, client type, and date range.
   - **Individual Response Details View**: Comprehensive inspection of each client's ratings and remarks.
   - **One-Click CSV Export**: Download all survey responses formatted for ARTA reporting and analysis.
5. **Database Ready**:
   - Configured out of the box with zero-setup SQLite database (`database/database.sqlite`), with easy switching to MySQL / MariaDB / PostgreSQL.
   - Includes seeders with realistic public service data for immediate demonstration.

---

## 🚀 Quick Start Guide

### 1. Requirements
- PHP 8.2 or higher (PHP 8.5 supported)
- Composer

### 2. Database Setup & Migration
The application comes pre-configured with **SQLite** by default:

```bash
# 1. Run migrations and seed sample survey data (35 realistic responses included)
php artisan migrate --seed
```

If you prefer to use **MySQL**, update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citizens_charter_survey
DB_USERNAME=root
DB_PASSWORD=your_password
```
Then run `php artisan migrate --seed`.

### 3. Start the Local Server
```bash
php artisan serve
```

The application will be live at:
- **Client Survey Form**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Analytics Dashboard**: [http://127.0.0.1:8000/admin/surveys](http://127.0.0.1:8000/admin/surveys)
- **Export Responses to CSV**: [http://127.0.0.1:8000/admin/surveys/export](http://127.0.0.1:8000/admin/surveys/export)

---

## 📊 Database Schema (`survey_responses`)

| Column | Type | Description |
|---|---|---|
| `id` | BigIncrements | Primary Key |
| `reference_no` | String (32) | Unique Tracking Number (`CSM-YYYYMMDD-XXXXXX`) |
| `client_type` | String | Citizen / Business / Government |
| `transaction_date` | Date | Date of transaction |
| `sex` | String | Male / Female / Prefer not to say |
| `age_group` | String | 19 or below, 20-34, 35-49, 50-64, 65 and above |
| `region` | String (Nullable) | Region of residence / office |
| `office_transacted`| String | Frontline Office / Division transacted with |
| `service_availed` | String | Specific frontline service availed |
| `service_availed_other`| String (Nullable) | Description if service was 'Other' |
| `cc1` | UnsignedTinyInt | Charter Awareness (1 to 4) |
| `cc2` | UnsignedTinyInt (Nullable) | Charter Visibility (1 to 5, or N/A) |
| `cc3` | UnsignedTinyInt (Nullable) | Charter Helpfulness (1 to 4, or N/A) |
| `sqd0` to `sqd8` | UnsignedTinyInt (Nullable) | Service Quality Dimension ratings (1 to 5, or NULL for N/A) |
| `suggestions` | Text (Nullable) | Client comments, feedback, or commendations |
| `respondent_name` | String (Nullable) | Client name (Optional) |
| `contact_number` | String (Nullable) | Client contact number (Optional) |
| `email` | String (Nullable) | Client email (Optional) |
| `ip_address` | String (45) | Client IP address |
| `user_agent` | Text | Client Browser Agent |
| `created_at` / `updated_at` | Timestamps | Record creation / update timestamps |

---

## 🛠️ Testing & Seeders

To add more sample survey responses for testing:
```bash
php artisan db:seed --class=SurveyResponseSeeder
```

To run the automated test suite:
```bash
php artisan test
```

---

## ⚖️ Legal & Regulatory Compliance
- **Republic Act No. 11032**: Ease of Doing Business and Efficient Government Service Delivery Act of 2018.
- **Anti-Red Tape Authority (ARTA) Memorandum Circular No. 2022-05**: Standardized Client Satisfaction Measurement (CSM).
- **Republic Act No. 10173**: Data Privacy Act of 2012.
