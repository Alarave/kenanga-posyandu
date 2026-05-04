# Backend Architecture Optimization Plan

**Goal**: Enhance the performance, reliability, and security of the Posyandu Admin Dashboard backend.

---

## 1. Database & Performance Optimization

### [MODIFY] [WhoWeightForAge.php](file:///c:/Users/HP/posyandu-admin-dashboard/app/Models/WhoWeightForAge.php) (and other WHO models)
- **Change**: Implement internal memoization for `getReference`.
- **Reason**: Static reference data should not be queried repeatedly in loops (prevents SQL saturation during bulk processing).

### [MODIFY] [NutritionCalculatorService.php](file:///c:/Users/HP/posyandu-admin-dashboard/app/Services/NutritionCalculatorService.php)
- **Change**: Use a dedicated DTO (Data Transfer Object) for results instead of raw arrays.
- **Reason**: Type safety and better IDE support across the service layer.

---

## 2. Reliability & Transaction Safety

### [MODIFY] [MedicalRecordService.php](file:///c:/Users/HP/posyandu-admin-dashboard/app/Services/MedicalRecordService.php)
- **Change**: Wrap `createRecord` and `updateRecord` in `DB::transaction`.
- **Reason**: Ensures atomicity between record creation, activity logging, and potential notification triggers.
- **Change**: Move `sendGrowthAlert` to a Laravel Queue (`ShouldQueue`).
- **Reason**: Prevents external API latency (WhatsApp) from blocking the user's request.

---

## 3. Security & Access Control

### [MODIFY] [HasPosyanduAccess.php](file:///c:/Users/HP/posyandu-admin-dashboard/app/Models/Concerns/HasPosyanduAccess.php)
- **Change**: Refactor private methods to `protected` to allow cleaner overrides.
- **Change**: Implement a global query scope option for automatic filtering where appropriate.

---

## 4. Scalability Improvements

### [MODIFY] [ReportService.php](file:///c:/Users/HP/posyandu-admin-dashboard/app/Services/ReportService.php)
- **Change**: Optimize the age grouping logic using a single database aggregation where possible, or refactor the loop to be more efficient.
- **Change**: Prepare the groundwork for asynchronous PDF generation (Job-based).

---

## Verification Plan

### Automated Tests
- Run `php artisan test` to ensure no regressions in nutrition calculation or report generation.
- Add specific test cases for transaction rollbacks.

### Manual Verification
- Monitor SQL query count during a monthly report generation to verify caching effect.
- Check Laravel Horizon/Queue logs for background WhatsApp notifications.
