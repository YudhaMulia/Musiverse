# Development Documentation - Cagar Budaya Palembang App
**Tanggal:** 14 Oktober 2026  
**Project:** Dokumentasi & Eksplorasi Cagar Budaya Palembang (Heritage Sites)  
**Lomba:** Untuk kebutuhan kompetisi/dokumentasi

---

## 📋 Ringkasan Eksekutif

Aplikasi Laravel berbasis Material Design 3 untuk mendokumentasikan, mengeksplorasi, dan mendata cagar budaya (heritage sites) di Palembang, Indonesia. Aplikasi dilengkapi carousel image, upload gambar lokal, sistem rating, dan peta interaktif (planned).

**Stack:** Laravel 13.36, PHP 8.3, MySQL, Tailwind CSS, Blade Templating

---

## 🚀 Timeline Development

### Phase 1: Setup & Database Design (2026-10-14 16:29 - 16:45)

#### Initial Setup
- Verifikasi PHP 8.3 & Composer
- Install Laravel Boost untuk optimization
- Setup database MySQL dengan migrations terurut

**Keputusan Teknis:**
- Gunakan Eloquent ORM untuk relasi data
- Dark theme dengan Material Design 3 color palette
- Local storage untuk image upload (bukan cloud)

#### Database Schema Design
```
Eras (Historical Periods)
├── id, name, year_range, color_code
├── hasMany: CagarBudaya

Locations (Geographic Data)
├── id, name, latitude, longitude, address, district
├── hasMany: CagarBudaya

CagarBudaya (Heritage Sites - Main Table)
├── id, name, slug, era_id, location_id
├── short_description, long_description
├── image_url, local_image_path, ai_reconstruction_url
├── year_built, architect, original_function, current_function
├── registration_number, status, view_count, is_featured
├── belongsTo: Era, Location
├── hasMany: AudioTour, VisitorRating (planned), VisitorImage (planned)

AudioTour
├── id, cagar_budaya_id, narration, duration, language
├── belongsTo: CagarBudaya

VisitorRating (Planned)
├── id, cagar_budaya_id, user_id, rating, comment

VisitorImage (Planned)
├── id, cagar_budaya_id, user_id, image_path, description
```

**Masalah & Solusi:**
- ❌ **Error:** Migration foreign key reference sebelum parent table dibuat
- ✅ **Solusi:** Rename migrations dengan urutan yang tepat (000001-000004)

---

### Phase 2: API & Controller Setup (16:45 - 17:00)

#### Controllers Built

**HomeController**
- Fetch carousel sites (up to 6 dengan images)
- Fetch featured sites (up to 3 flagged sites)
- Calculate stats (total sites, eras, locations)
- Pass data ke blade template

**CagarBudayaController**
- Index page dengan filtering by era
- Detail/show page dengan full information
- Related sites sidebar
- Audio tour player

**CagarBudayaApiController** (REST API)
- GET `/api/cagar-budaya` - List semua dengan pagination
- Filter by era, location, nearby sites
- Search functionality

**Admin\CagarBudayaAdminController** (Image Management)
- Upload image ke `/storage/app/public/cagar-budaya/`
- Validasi: max 5MB, image types only
- Auto-delete old image saat upload baru
- Update `local_image_path` & `image_url` di database

---

### Phase 3: Frontend - Home Page (17:00 - 17:30)

#### Hero Section
- **Carousel Image Display** - Rotate heritage site photos setiap 5 detik
- Navigation arrows (previous/next)
- Indicator dots at bottom
- Dark overlay gradient untuk text readability
- Auto-pause on hover, resume on mouse leave

**Features:**
- Smooth fade transitions (1000ms)
- Responsive design
- Manual & automatic navigation

#### Featured Sites Grid
- Grid 3 kolom (responsive 1 kolom mobile)
- Card dengan image preview (h-44, object-cover)
- Era badge & year tag
- CTA button "Tinjau Lokasi"
- Hover scale effect

#### Stats Banner
- 3 stat cards dengan icon
- Total sites, Eras, Locations count
- Hover shadow effects

#### Features Section
- 3 feature cards:
  1. Peta & Rute Eksplorasi
  2. AI Storyteller & Rekonstruksi Visual
  3. Match Card Gamification

#### How It Works Section
- 3 step process dengan connector lines
- Step 1: Pilih Situs
- Step 2: Baca Ceritanya
- Step 3: Mainkan Gamenya

#### CTA Section
- "Siap Untuk Petualangan?" call-to-action
- Dual buttons (Explore & Learn More)

**Masalah & Solusi:**
- ❌ **Error:** `$loop->last` undefined di template
- ✅ **Solusi:** Remove conditional, always display connector lines

---

### Phase 4: Frontend - Detail Page & Image Management (17:30 - 18:00)

#### Detail Page (Show Template)
- Breadcrumb navigation
- Full-size hero image dengan info badges
- Factsheet dengan metadata
- Audio tour player section
- Related sites carousel
- AI reconstruction section (conditional)

**Latest Improvement:**
- Image display: `object-contain` (tidak terpotong)
- Background hitam untuk contrast
- Flexible height container
- Max-height 600px tapi proporsional

#### Admin Image Upload Panel
- Grid layout semua heritage sites
- File input dengan validation
- Upload button (POST endpoint)
- Delete button (DELETE endpoint)
- Status indicator (gambar tersimpan/belum)
- Instructions panel

**Features:**
- Drag & drop capable
- Real-time validation
- Success/error messages
- Automatic old image deletion

**Masalah & Solusi:**
- ❌ **Error:** Nested forms (upload + delete) dalam satu container
- ✅ **Solusi:** Separate forms, delete form hidden, delete button punya `form="deleteForm{id}"` attribute
- ❌ **Error:** DELETE method error pada POST route
- ✅ **Solusi:** Clear route cache, verify routes with `php artisan route:list`

---

### Phase 5: Image Display Fixes (Latest)

#### Home Page Featured Sites
- Kembali ke **grid 3 kolom** standard
- Card dengan fixed height (h-44)
- Image dengan `object-cover` (thumbnail view)
- Normal overflow-hidden

#### Detail Page Heritage Image
- Image dengan `object-contain` (FULL display)
- Background hitam untuk clarity
- Min-height 400px, max-height 600px
- **TIDAK TERPOTONG** - sesuai aspek ratio asli

**User Request Clarification:**
- User ingin gambar di detail page **100% full** tanpa terpotong
- Home page tetap normal (grid 3 kolom, thumbnail)
- Perbedaan design: thumbnail vs fullscreen display

---

## ✨ Fitur yang Sudah Dibangun

### ✅ Completed Features

1. **Database Architecture**
   - 4 main tables dengan relasi terstruktur
   - Migration system with proper sequencing
   - Seeder untuk initial data

2. **Image Management System**
   - Local file upload ke `/storage/public/cagar-budaya/`
   - Validasi ukuran & format file
   - Auto image replacement on re-upload
   - Public URL generation
   - Admin panel untuk manage per-site

3. **Home Page**
   - Hero carousel dengan auto-rotate (5 sec interval)
   - Featured sites grid (3 kolom)
   - Stats display
   - Features showcase
   - How-it-works section
   - CTA section

4. **Detail/Show Page**
   - Full-size image display (object-contain)
   - Metadata factsheet
   - Audio tour player
   - Related sites
   - Breadcrumb navigation

5. **API Endpoints**
   - REST API untuk mobile/external access
   - Filter by era, location
   - Pagination support
   - Search functionality

6. **Styling & Theme**
   - Material Design 3 color palette
   - Dark mode default
   - Responsive design
   - Tailwind CSS utilities
   - Custom font system (Manrope, Noto Serif, Space Grotesk)

7. **Admin Panel**
   - Image upload interface
   - Per-site management
   - Status indicators
   - Instructions guide

---

### ⏳ Planned Features (Next Phase)

1. **Leaflet.js Map Integration**
   - Interactive map with heritage site markers
   - Marker clustering
   - Click marker → detail page navigation
   - Multi-layer support (satellite, street, dark)
   - Location search/filtering

2. **Visitor Contributions System**
   - **Visitor Photo Gallery**
     - Authenticated users upload images
     - Photo moderation queue
     - Display visitor photos alongside official images
     - Photo attribution & uploader info
   
   - **Rating System**
     - 1-5 star rating per site
     - Comment/review from visitors
     - Rating aggregation & display
     - Only 1 rating per visitor per site
   
   - **User Authentication**
     - Register/login system
     - User profile
     - My contributions history
     - Visitor badge/achievement system

3. **AI Storyteller** (Deprioritized)
   - Audio narration generation
   - Multi-language support
   - Dynamic text-to-speech

4. **Gamification**
   - Match card game
   - Points system
   - Digital badges
   - Leaderboard

---

## 🏗️ Technical Architecture

### Tech Stack
- **Backend:** Laravel 13.36
- **Language:** PHP 8.3
- **Database:** MySQL
- **Frontend:** Blade Templates, Tailwind CSS
- **Icons:** Material Symbols Outlined
- **Fonts:** Google Fonts (Manrope, Noto Serif, Space Grotesk)
- **Future:** Leaflet.js, Alpine.js (interactivity)

### Project Structure
```
cagar-budaya-app/
├── app/
│   ├── Models/
│   │   ├── Era.php
│   │   ├── Location.php
│   │   ├── CagarBudaya.php
│   │   └── AudioTour.php
│   └── Http/Controllers/
│       ├── HomeController.php
│       ├── CagarBudayaController.php
│       ├── AudioTourController.php
│       ├── Admin/CagarBudayaAdminController.php
│       └── Api/CagarBudayaApiController.php
├── database/
│   ├── migrations/ (4 main + 1 schema addition)
│   └── seeders/
├── resources/views/
│   ├── layouts/app.blade.php (main layout + carousel JS)
│   ├── components/
│   │   ├── header.blade.php
│   │   └── footer.blade.php
│   ├── home/index.blade.php
│   ├── cagar-budaya/
│   │   ├── index.blade.php (listing)
│   │   └── show.blade.php (detail)
│   └── admin/cagar-budaya/index.blade.php
├── routes/web.php (all routes)
├── storage/
│   └── app/public/cagar-budaya/ (uploaded images)
└── docs/
    └── DEVELOPMENT_DOCUMENTATION.md (this file)
```

### Routing Structure
```
GET  /                              → HomeController@index
GET  /cagar-budaya                  → CagarBudayaController@index
GET  /cagar-budaya/{slug}           → CagarBudayaController@show
GET  /admin/cagar-budaya            → CagarBudayaAdminController@index
POST /admin/cagar-budaya/{id}/upload-image → CagarBudayaAdminController@updateImage
DELETE /admin/cagar-budaya/{id}/image      → CagarBudayaAdminController@destroy

API Routes:
GET  /api/cagar-budaya              → CagarBudayaApiController@index
```

---

## 🐛 Issues Encountered & Solutions

### 1. Migration Sequencing Error
**Problem:** Foreign key reference failed - CagarBudaya table terbentuk sebelum Location table
```
SQLSTATE[HY000]: General error: 1005 Can't create table
```
**Solution:** Rename migrations dengan urutan yang tepat:
- 2026_10_14_000001 → eras
- 2026_10_14_000002 → locations  
- 2026_10_14_000003 → cagar_budayas
- 2026_10_14_000004 → audio_tours

**Lesson:** Always check foreign key dependencies sebelum naming migrations

---

### 2. String Column Too Short for URLs
**Problem:** `image_url` VARCHAR(255) tidak cukup untuk Google Images URL (panjang ~400+ chars)
**Solution:** Change column type to TEXT dalam migration add_local_image_path_to_cagar_budayas
```php
$table->text('image_url')->nullable()->change();
$table->text('ai_reconstruction_url')->nullable()->change();
```

---

### 3. Loop Variable Undefined in Blade
**Problem:** `$loop->last` undefined when used outside @foreach
```
Undefined variable: loop
```
**Solution:** Remove conditional check, always render connector lines

---

### 4. Image Display Truncation (Featured Sites)
**Problem:** Gambar tampil setengah karena container punya fixed height & object-cover
**Original:** `h-44` fixed height dengan `object-cover` → crops image
**Solution:** 
- Home: tetap `h-44`, `object-cover` (thumbnail style)
- Detail: `object-contain`, no fixed height, flexible container (fullscreen style)

---

### 5. Nested Forms Issue (Admin Upload)
**Problem:** Delete form nested dalam upload form → both buttons submit to wrong endpoint
```html
<form action="/upload">
  <button>Upload</button>
  <form action="/delete">  <!-- NESTED - WRONG! -->
    <button>Delete</button>
  </form>
</form>
```
**Solution:** Separate forms, use `form` attribute on button to link to hidden form
```html
<form id="uploadForm">...</form>
<form id="deleteForm" style="display: none;">...</form>
<button form="uploadForm">Upload</button>
<button form="deleteForm">Delete</button>
```

---

### 6. DELETE Method Not Supported on POST Route
**Problem:** After nested form fix, DELETE still went to upload-image endpoint
```
The DELETE method is not supported for route admin/cagar-budaya/2/upload-image
```
**Solution:** 
- Clear route cache: `php artisan route:cache`
- Verify routes: `php artisan route:list | grep destroy-image`
- Confirm form action URLs match route names

---

## 📊 Database Structure Details

### Eras Table
```sql
CREATE TABLE eras (
    id BIGINT PRIMARY KEY,
    name VARCHAR(100),        -- 'Sriwijaya', 'Kesultanan', 'Kolonial'
    year_range VARCHAR(50),   -- '650-1377', '1527-1821', '1821-1945'
    color_code VARCHAR(7),    -- Hex color untuk UI
    created_at, updated_at
);
```

### Locations Table
```sql
CREATE TABLE locations (
    id BIGINT PRIMARY KEY,
    name VARCHAR(100),
    latitude DOUBLE,
    longitude DOUBLE,
    address TEXT,
    district VARCHAR(100),    -- 'Ilir Barat II', 'Ilir Timur I', etc
    created_at, updated_at
);
```

### CagarBudayas Table
```sql
CREATE TABLE cagar_budayas (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    era_id BIGINT (FK→eras),
    location_id BIGINT (FK→locations),
    short_description TEXT,
    long_description TEXT,
    image_url TEXT,                      -- Local uploaded or external
    local_image_path VARCHAR(255),       -- Path to /storage/app/public/
    ai_reconstruction_url TEXT,          -- AI-generated image (optional)
    year_built VARCHAR(50),
    architect VARCHAR(100),
    original_function VARCHAR(255),
    current_function VARCHAR(255),
    registration_number VARCHAR(100),
    status ENUM('active', 'inactive'),
    view_count INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT false,
    created_at, updated_at
);
```

### AudioTours Table
```sql
CREATE TABLE audio_tours (
    id BIGINT PRIMARY KEY,
    cagar_budaya_id BIGINT (FK→cagar_budayas),
    narration TEXT,
    duration INT,           -- seconds
    language VARCHAR(10),   -- 'id', 'en'
    created_at, updated_at
);
```

---

## 🎨 Design System

### Material Design 3 Color Palette (Dark Mode)
```
Primary:                #ffb2b6 (Pink)
Secondary:              #ffc83c (Gold/Yellow)
Tertiary:               #ffb3af (Light Pink)

Surface:                #1c1013 (Very Dark Brown)
Surface Container:      #291c1f
Surface Container Low:  #25181b
Surface Container High: #34262a
Surface Bright:         #443539

On Surface:             #fffbfe (Off-white)
On Surface Variant:     #debfc0 (Taupe)

Primary Container:      #720921 (Deep Maroon)
Secondary Container:    #af8d11 (Deep Gold)
```

### Typography System
```
Display Large:   56px, Noto Serif, 700
Headline Large:  40px, Noto Serif, 600
Headline Medium: 28px, Noto Serif, 600
Title Large:     20px, Noto Serif, 600
Body Large:      18px, Manrope, 400
Label Large:     14px, Space Grotesk, 600
```

---

## 📈 Performance Optimizations

1. **Image Optimization**
   - Local storage instead of external API (faster load)
   - Max 5MB upload limit
   - JPG/PNG compression

2. **Database Query**
   - Eager loading with `with()` to prevent N+1
   - Pagination on large lists
   - Indexing on slug & foreign keys

3. **Frontend**
   - Tailwind CSS production build
   - Minimal JavaScript (only carousel)
   - SVG icons via Material Symbols font

---

## 🚀 Deployment Checklist

- [ ] Database migrations run: `php artisan migrate`
- [ ] Storage link created: `php artisan storage:link`
- [ ] Assets compiled: `npm run build`
- [ ] Environment configured: `.env` with DB credentials
- [ ] Cache cleared: `php artisan cache:clear`
- [ ] Routes cached: `php artisan route:cache`
- [ ] File permissions: `/storage` writable

---

## 📝 User Request Summary

### Initial Requirements (Phase 1)
✅ Home page dengan 7 sections:
- Hero with stats
- Features showcase
- Featured sites preview
- How-it-works steps
- CTA sections
- Footer

✅ Database untuk heritage sites dengan:
- Locations & coordinates
- Audio tours
- Historical eras
- Metadata fields

✅ Display pages dengan:
- Detail view
- Metadata display
- Related sites

### Mid-Development Changes
✅ Real photos instead of AI reconstruction (user feedback)
- Added local_image_path column
- Upload system untuk gambar asli
- Removed AI reconstruction dari seeder

✅ Image carousel di hero section
- 5-detik auto-rotate
- Manual navigation (prev/next)
- Indicator dots
- Smooth transitions

✅ Image fix untuk detail page
- Object-contain (tidak terpotong)
- Flexible height container
- Dark background untuk contrast

### Future Requirements (Planned)
⏳ Leaflet.js interactive map
⏳ Visitor photo gallery system
⏳ Rating & review system
⏳ User authentication
⏳ Gamification features

---

## 📞 Support & Documentation

### Key Files to Reference
- `routes/web.php` - All route definitions
- `app/Http/Controllers/HomeController.php` - Home page logic
- `app/Http/Controllers/Admin/CagarBudayaAdminController.php` - Image upload logic
- `resources/views/home/index.blade.php` - Home template + carousel
- `resources/views/cagar-budaya/show.blade.php` - Detail page
- `app/Models/CagarBudaya.php` - Main model with relationships

### Useful Commands
```bash
# Development
php artisan serve --host=127.0.0.1 --port=8000

# Database
php artisan migrate
php artisan db:seed

# Cache & Optimization
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache

# Storage
php artisan storage:link

# Debugging
php artisan tinker
php artisan route:list
```

---

## ✅ Final Status

**Current Version:** v1.0.0 (MVP Complete)
**Last Updated:** 2026-10-14 17:18:09 UTC
**Status:** ✅ Fully Functional - Ready for Presentation

**Working Features:**
- ✅ Home page carousel & layout
- ✅ Heritage sites detail pages
- ✅ Local image upload system
- ✅ Admin panel for image management
- ✅ REST API endpoints
- ✅ Responsive design
- ✅ Material Design 3 theme

**Ready for Next Phase:**
- ⏳ Leaflet.js map implementation
- ⏳ Visitor contributions system
- ⏳ Rating & review features
- ⏳ User authentication system

---

**Dokumentasi ini dibuat untuk keperluan lomba/kompetisi sebagai bukti proses development.**
