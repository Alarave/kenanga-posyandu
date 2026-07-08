# Walkthrough

We resolved ten main issues in the Posyandu management system:
1. The blank content area on the article edit page (`/admin/articles/{id}/edit`).
2. The non-functional "Ingat Perangkat" (Remember Me) checkbox on the login page.
3. The search bar on both the Admin Article Management and Public Articles pages not correctly filtering results.
4. Removed the "Pedukuhan" field when creating or editing a Posyandu.
5. Inconsistency in active cadre/kader counts between the admin panel and public pages.
6. Case-sensitivity issues on all search bars when running on PostgreSQL (production on Railway).
7. Vertical text wrapping issue on the "Tulis Artikel Baru" button.
8. Enhanced the custom block-based article editor to support copy-pasting multi-line text and using the Tab key for indentation.
9. Optimized search inputs to update dynamically while typing without losing focus, and activated the mobile search bar in the public header.
10. Fixed the article editor's auto-capitalization logic to ignore HTML entities, stopping `&nbsp;` from corrupting into `&Amp;Nbsp;`.

## Changes Made

### 1. Fix Blank Edit Article Page
- Modified [ArticleUpdate.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Management/ArticleUpdate.php) to add the `#[Layout('layouts.admin-layout')]` attribute and its import.
- Created [ArticleUpdateTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/Admin/ArticleUpdateTest.php) to ensure the edit page renders correctly inside the admin layout and can successfully update and persist article content.

### 2. Fix Remember Me Feature on Login
- Modified [LoginController.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Http/Controllers/Auth/LoginController.php) to parse the remember checkbox boolean and pass it into Laravel's `Auth::attempt($credentials, $remember)` method.
- Modified [LoginTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/Auth/LoginTest.php) to add a test checking that the `remember_token` is correctly set.

### 3. Fix Article Search (Public & Admin Sides)
- Modified [Article.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Models/Article.php) inside the `scopeFilter` query builder:
  - Enclosed the search parameters within a subquery callback (`where(function($sub) ...)`) to fix the SQL operator precedence bug which allowed draft articles to leak into public search results.
  - Extended the query to search not only by `title` and `content` but also `description`, category name, and user/author name.
- Modified [ArticleService.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Services/ArticleService.php) inside the `getFilteredArticles` query to search not only by `title` and `content` but also `description`, category name, and user/author name.
- Created [ArticleSearchTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/Admin/ArticleSearchTest.php) to verify search filtering behavior.

### 4. Remove Pedukuhan Field from Posyandu Forms
- Created a migration [2026_07_08_100000_make_pedukuhan_id_nullable_in_posyandus_table.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/database/migrations/2026_07_08_100000_make_pedukuhan_id_nullable_in_posyandus_table.php) to make the `pedukuhan_id` column nullable in the `posyandus` table.
- Modified [PosyanduRequest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Http/Requests/PosyanduRequest.php) to make `pedukuhan_id` validation `nullable` instead of `required`.
- Modified [create.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/posyandu-management/create.blade.php) and [update.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/posyandu-management/update.blade.php) to remove the Pedukuhan input field completely.
- Modified [PosyanduController.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Http/Controllers/Web/PosyanduController.php) to clean up queries for the `pedukuhans` data, since it is no longer required in the views.
- Updated [PosyanduManagementTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/Admin/PosyanduManagementTest.php) to test that creating and updating a Posyandu without `pedukuhan_id` works.

### 5. Align Cadre Counts (Admin Panel vs. Public About Page)
- Modified [AboutPageService.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Services/AboutPageService.php) inside the `getCadres` function to fetch active users with `superadmin`, `admin`, and `kader` roles since superadmins (like the Secretary) are also active cadres.
- Modified [UserManagement.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Management/UserManagement.php) inside the `render` function to compute the "Kader Aktif" stat using `whereIn('role', ['superadmin', 'admin', 'kader'])`.
- Modified [AboutMetricsTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/AboutMetricsTest.php) to use the updated role check array.
- Created [UserManagementTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/Admin/UserManagementTest.php) to ensure the component calculates and displays the correct count of active cadres.

### 6. Make Search Bars Case-Insensitive (PostgreSQL Compatibility)
- Because the production server on Railway uses **PostgreSQL**, search queries using `LIKE` were behaving case-sensitively, making the searches fail for various casings.
- Updated all search queries across the codebase to use `LOWER(column) LIKE ?` with `strtolower($searchTerm)` for case-insensitive matching.

### 7. Prevent "Tulis Artikel Baru" Button Text Wrapping
- Modified [index.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/article-management/index.blade.php) to add the `whitespace-nowrap` and `shrink-0` classes to the "Tulis Artikel Baru" anchor button. This forces the button layout to stay horizontal on single-line and prevents vertical wrapping on smaller viewports.

### 8. Enhance Custom Article Editor (Multi-line Paste & Tab Key Support)
- Modified the editor javascript in both [create.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/article-management/create.blade.php) and [update.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/article-management/update.blade.php):
  - **Multi-line Paste**: Intercepted the paste event listener. If the pasted content is multi-line, it splits the text by newlines, puts the first line at the cursor, and creates separate paragraph blocks for all subsequent lines (Notion/Medium block style). This resolves the bug where pasting multiple paragraphs merged everything into a single giant paragraph block.
  - **Tab Key Indentation**: Handled the `Tab` key event inside `handleKeydown` to prevent default browser focus switching, and instead insert four non-breaking spaces (`&nbsp;&nbsp;&nbsp;&nbsp;`) for alignment/indentation of text.

### 9. Optimize Live Search Update & Fix Mobile Search Bar
- **Real Mobile Search Hook**: Modified [navbar.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/components/layouts/ui/navbar.blade.php) to replace the static dummy mobile search input with the real `@livewire('global-search')` component so mobile search queries are fully functional.
- **Retain Input Focus (Live Update)**: Added a unique `wire:key` attribute to all admin search input elements. In Livewire, when the DOM re-renders upon receiving a debounced input query, the input element could get re-created and lose focus (forcing users to press Enter or click the input again). Adding `wire:key` preserves focus, allowing users to type queries continuously while watching search results update live on their screen.

### 10. Fix HTML Entity Capitalization Corruption
- Modified the `capitalizeSentences` function in [create.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/article-management/create.blade.php) and [update.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/article-management/update.blade.php) to parse and skip HTML entities starting with `&` and ending with `;` (such as `&nbsp;`).
- Previously, the function treated entities as normal letters and capitalized them (e.g. `&nbsp;` became `&Nbsp;` after a period). This caused the browser to double-encode the ampersand, corrupting it into the literal text `&Amp;Nbsp;` displayed inside the editor text area.
