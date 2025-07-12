```mermaid
classDiagram
    User ||--o{ Posyandu : "manages"
    User ||--o{ Schedule : "creates"
    User ||--o{ Gallery : "uploads"
    User ||--o{ Article : "writes"
    User ||--o{ MedicalRecord : "records"
    
    Pedukuhan ||--o{ Posyandu : "contains"
    
    Posyandu ||--o{ Schedule : "has"
    Posyandu ||--o{ Gallery : "has"
    Posyandu ||--o{ Patient : "serves"
    Posyandu }|--|| User : "managed by"
    Posyandu }|--|| Pedukuhan : "located in"
    
    Patient ||--o{ MedicalRecord : "has"
    Patient }|--|| Posyandu : "registered at"
    
    Article }|--|| User : "authored by"
    
    MedicalRecord }|--|| Patient : "belongs to"
    MedicalRecord }|--|| User : "recorded by"
    
    Schedule }|--|| Posyandu : "belongs to"
    Schedule }|--|| User : "created by"
    
    Gallery }|--|| Posyandu : "belongs to"
    Gallery }|--|| User : "uploaded by"

    class User {
        +user_id: int [PK]
        +name: string
        +email: string
        +username: string
        +password: string
        +role: string
        +is_active: boolean
        +verified_email: boolean
        +attempt_login: int
        +block_expires: timestamp
        +created_at: timestamp
        +updated_at: timestamp
        
        +createUser(): User
        +getUserById(int): User
        +getAllUsers(UserFilter): User[]
        +updateUser(UserData): boolean
        +deleteUser(int): boolean
        +login(string, string): AuthResponse
        +logout(): void
        +changePassword(string, string): boolean
        +resetPassword(string): boolean
        +updateProfile(UserProfile): boolean
        +verifyEmail(string): boolean
        +deactivateUser(int): boolean
        +restoreUser(int): boolean
        +searchUsers(string): User[]
        +countUsers(): int
    }

    class Pedukuhan {
        +pedukuhan_id: int [PK]
        +name: string
        +postal_code: string
        +geo_location: json
        +created_at: timestamp
        +updated_at: timestamp
        
        +createPedukuhan(PedukuhanData): Pedukuhan
        +getPedukuhanById(int): Pedukuhan
        +getAllPedukuhan(): Pedukuhan[]
        +updatePedukuhan(int, PedukuhanData): boolean
        +deletePedukuhan(int): boolean
        +addPosyandu(PosyanduData): Posyandu
        +getAllPosyandu(): Posyandu[]
        +updateInfo(int, json): boolean
        +softDelete(int): boolean
        +searchPedukuhan(string): Pedukuhan[]
        +countPosyandu(): int
    }

    class Posyandu {
        +posyandu_id: int [PK]
        +pedukuhan_id: int [FK]
        +name: string
        +address: text
        +unique_code: string
        +logo_photo: text
        +created_at: timestamp
        +updated_at: timestamp
        
        +createPosyandu(PosyanduData): Posyandu
        +getPosyanduById(int): Posyandu
        +getAllPosyandu(): Posyandu[]
        +updatePosyandu(int, PosyanduData): boolean
        +deletePosyandu(int): boolean
        +addSchedule(ScheduleData): Schedule
        +addPatient(PatientData): Patient
        +addGallery(GalleryData): Gallery
        +addUser(UserData): User
        +generateReport(date, date): Report
        +archivePosyandu(int): boolean
        +getActiveSchedules(): Schedule[]
        +countPatients(): int
    }

    class Schedule {
        +schedule_id: int [PK]
        +posyandu_id: int [FK]
        +user_id: int [FK]
        +title: string
        +description: text
        +start_time: timestamp
        +end_time: timestamp
        +location: text
        +status: string
        +created_at: timestamp
        +updated_at: timestamp
        
        +createSchedule(ScheduleData): Schedule
        +getScheduleById(int): Schedule
        +getAllSchedules(): Schedule[]
        +updateSchedule(int, ScheduleData): boolean
        +deleteSchedule(int): boolean
        +createEvent(): boolean
        +updateStatus(int, string): boolean
        +sendReminder(): boolean
        +cancelEvent(int): boolean
        +getUpcomingEvents(): Schedule[]
        +countParticipants(): int
    }

    class Gallery {
        +gallery_id: int [PK]
        +posyandu_id: int [FK]
        +user_id: int [FK]
        +title: string
        +description: text
        +photo: text
        +type: string
        +created_at: timestamp
        +updated_at: timestamp
        
        +createGallery(GalleryData): Gallery
        +getGalleryById(int): Gallery
        +getAllGalleries(): Gallery[]
        +updateGallery(int, GalleryData): boolean
        +deleteGallery(int): boolean
        +uploadPhoto(string): boolean
        +addDescription(int, string): boolean
        +changeType(int, string): boolean
        +removePhoto(int): boolean
        +searchPhotos(string): Gallery[]
        +countByType(string): int
    }

    class Patient {
        +patient_id: int [PK]
        +posyandu_id: int [FK]
        +age_category: string
        +id_number: string
        +full_name: string
        +birth_date: date
        +gender: char
        +address: text
        +phone_number: string
        +profile_photo: text
        +created_at: timestamp
        +updated_at: timestamp
        
        +createPatient(PatientData): Patient
        +getPatientById(int): Patient
        +getAllPatients(): Patient[]
        +updatePatient(int, PatientData): boolean
        +deletePatient(int): boolean
        +registerPatient(PatientData): Patient
        +updateProfile(int, PatientProfile): boolean
        +checkAgeCategory(int): string
        +softDelete(int): boolean
        +exportMedicalHistory(int): PDF
        +searchPatients(string): Patient[]
        +countByAgeGroup(): Map
    }

    class Article {
        +article_id: int [PK]
        +user_id: int [FK]
        +title: string
        +content: text
        +thumbnail: text
        +slug: string
        +status: string
        +published_at: timestamp
        +created_at: timestamp
        +updated_at: timestamp
        
        +createArticle(ArticleData): Article
        +getArticleById(int): Article
        +getAllArticles(): Article[]
        +updateArticle(int, ArticleData): boolean
        +deleteArticle(int): boolean
        +publish(int): boolean
        +draft(int): boolean
        +generateSlug(string): string
        +archive(int): boolean
        +countViews(int): int
        +searchArticles(string): Article[]
        +getPopularArticles(): Article[]
    }

    class MedicalRecord {
        +medical_record_id: int [PK]
        +patient_id: int [FK]
        +user_id: int [FK]
        +visit_date: date
        +weight: decimal
        +height: decimal
        +head_circumference: decimal
        +immunization: string
        +complaint: text
        +diagnosis: text
        +nutrition_status: string
        +created_at: timestamp
        +updated_at: timestamp
        
        +createMedicalRecord(MedicalRecordData): MedicalRecord
        +getMedicalRecordById(int): MedicalRecord
        +getAllMedicalRecords(): MedicalRecord[]
        +updateMedicalRecord(int, MedicalRecordData): boolean
        +deleteMedicalRecord(int): boolean
        +createRecord(): boolean
        +updateDiagnosis(int, string): boolean
        +generateNutritionReport(int): Report
        +exportToPDF(int): PDF
        +archiveRecord(int): boolean
        +getPatientHistory(int): MedicalRecord[]
        +getGrowthData(int): GrowthChart
    }

```