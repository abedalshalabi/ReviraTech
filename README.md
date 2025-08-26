# Revira Industrial - موقع الآلات والمعدات الصناعية

موقع إلكتروني احترافي ومتجاوب مخصص لشركة تعمل في مجال الآلات والمعدات الصناعية، يدعم اللغة العربية والإنجليزية بشكل كامل.

## 🌟 المميزات الرئيسية

### 🎨 التصميم والواجهة
- **تصميم متجاوب** يعمل على جميع الأجهزة
- **دعم كامل للغة العربية** مع اتجاه RTL
- **ألوان احترافية** مع تدرجات جميلة
- **تأثيرات حركية** احترافية
- **خط Cairo** للعربية

### 🌐 نظام متعدد اللغات
- **العربية والإنجليزية** مدعومتان
- **إمكانية إضافة لغات جديدة** بسهولة
- **دعم RTL/LTR** تلقائي
- **ترجمة شاملة** لجميع المحتويات

### 📦 إدارة المحتوى
- **منتجات متنوعة** مع صور ومواصفات
- **تصنيفات هرمية** للتنظيم
- **سلايدر ديناميكي** للصفحة الرئيسية
- **أخبار ومقالات** مع SEO محسن
- **وكلاء وموزعين** مع معلومات الاتصال

### 🔍 تحسين محركات البحث (SEO)
- **Meta tags** قابلة للتخصيص
- **URLs صديقة لمحركات البحث**
- **Schema.org markup** للمنتجات
- **Open Graph** و **Twitter Cards**
- **Sitemap.xml** تلقائي

### ⚡ الأداء والأمان
- **تحميل سريع** مع تحسين الصور
- **حماية CSRF** و **XSS**
- **ضغط الملفات** للتحسين
- **Cache ready** للـ CDN

## 🚀 التثبيت والتشغيل

### المتطلبات
- PHP 8.1+
- Composer
- MySQL/SQLite
- Node.js (اختياري للـ assets)

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone [repository-url]
cd revira-industrial
```

2. **تثبيت التبعيات**
```bash
composer install
npm install
```

3. **إعداد البيئة**
```bash
cp .env.example .env
php artisan key:generate
```

4. **إعداد قاعدة البيانات**
```bash
php artisan migrate:fresh --seed
```

5. **إنشاء رابط التخزين**
```bash
php artisan storage:link
```

6. **تشغيل الموقع**
```bash
php artisan serve
```

الموقع سيعمل على: `http://localhost:8000`

## 📁 هيكل المشروع

```
revira-industrial/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   ├── Helpers/             # Helper Functions
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   ├── views/              # Blade Templates
│   └── lang/               # Language Files
├── public/
│   ├── css/                # Custom CSS
│   └── images/             # Product Images
└── routes/
    └── web.php             # Web Routes
```

## 🎨 تخصيص التصميم

### تغيير الألوان
يمكنك تعديل الألوان في ملف `public/css/custom.css`:

```css
:root {
    --primary-color: #789c32;    /* اللون الأساسي */
    --secondary-color: #8fb03a;  /* اللون الثانوي */
    --accent-color: #a5c442;     /* اللون المميز */
    --success-color: #10b981;    /* لون النجاح */
    --danger-color: #ef4444;     /* لون الخطر */
}
```

### إضافة الصور
1. ضع الصور في `public/images/products/`
2. أضف مسار الصورة في قاعدة البيانات
3. الصور ستظهر تلقائياً في المنتجات

### تخصيص المحتوى
- **التصنيفات**: أضف/عدل في `CategorySeeder.php`
- **المنتجات**: أضف/عدل في `ProductSeeder.php`
- **السلايدر**: أضف/عدل في `SliderSeeder.php`
- **الأخبار**: أضف/عدل في `NewsSeeder.php`
- **الوكلاء**: أضف/عدل في `AgentSeeder.php`

## 📊 البيانات المضافة

### التصنيفات (9 تصنيفات)
- آلات التصنيع
- معدات النقل
- أدوات القياس
- معدات السلامة
- قطع الغيار
- آلات CNC (فرعي)
- آلات اللحام (فرعي)
- الرافعات الصناعية (فرعي)
- الرافعات الشوكية (فرعي)

### المنتجات (5 منتجات)
1. **آلة CNC للخراطة** - 135,000 ريال
2. **آلة لحام TIG** - 25,000 ريال
3. **رافعة جسرية** - 500,000 ريال
4. **رافعة شوكية كهربائية** - 180,000 ريال
5. **مقياس رقمي دقيق** - 500 ريال

### السلايدر (3 سلايدات)
- آلات ومعدات صناعية عالية الجودة
- حلول صناعية متكاملة
- أحدث التقنيات الصناعية

### الأخبار (3 أخبار)
- افتتاح معرض الآلات الصناعية 2024
- إطلاق خط إنتاج جديد للآلات الصناعية
- شراكة استراتيجية مع شركة ألمانية رائدة

### الوكلاء (4 وكلاء)
- شركة التقنية الصناعية (الرياض)
- شركة جدة للمعدات الصناعية (جدة)
- شركة الدمام للآلات الصناعية (الدمام)
- شركة مكة للتقنيات الصناعية (مكة)

## 🔧 الإعدادات المتقدمة

### إضافة منتج جديد
1. أضف البيانات في `ProductSeeder.php`
2. أضف الصورة في `public/images/products/`
3. شغل `php artisan migrate:fresh --seed`

### إضافة لغة جديدة
1. أضف اللغة في `LanguageSeeder.php`
2. أنشئ ملف ترجمة في `resources/lang/`
3. أضف الترجمات المطلوبة

### تخصيص SEO
- عدل Meta tags في الـ Views
- أضف Schema.org markup
- عدل إعدادات Google Analytics

## 📱 الروابط المتاحة

### الصفحات الرئيسية
- **الرئيسية**: `/ar` أو `/en`
- **المنتجات**: `/ar/products` أو `/en/products`
- **الأخبار**: `/ar/news` أو `/en/news`
- **الوكلاء**: `/ar/agents` أو `/en/agents`
- **اتصل بنا**: `/ar/contact` أو `/en/contact`
- **من نحن**: `/ar/about` أو `/en/about`

### صفحات المنتجات
- **قائمة المنتجات**: `/ar/products`
- **تفاصيل المنتج**: `/ar/products/{slug}`
- **فلترة المنتجات**: حسب التصنيف والسعر

## 🎯 المميزات التقنية

### Laravel Features
- **Eloquent ORM** للتعامل مع قاعدة البيانات
- **Blade Templating** للعرض
- **Route Model Binding** للروابط
- **Form Validation** للتحقق من البيانات
- **File Upload** للصور والملفات

### Frontend Features
- **Bootstrap 5** للتصميم
- **Font Awesome** للأيقونات
- **Google Fonts** للخطوط
- **Custom CSS** للتخصيص
- **JavaScript** للتفاعل

### SEO Features
- **Meta Tags** قابلة للتخصيص
- **Open Graph** للمشاركة
- **Twitter Cards** للتويتر
- **Schema.org** للبحث
- **Sitemap** تلقائي

## 🔒 الأمان

- **CSRF Protection** للحماية من الهجمات
- **XSS Protection** لحماية المدخلات
- **SQL Injection Protection** عبر Eloquent
- **File Upload Security** للصور
- **HTTPS Ready** للإنتاج

## 📈 الأداء

- **Image Optimization** لتحسين الصور
- **CSS/JS Minification** لضغط الملفات
- **Database Indexing** لسرعة الاستعلامات
- **Caching Ready** للتحسين
- **CDN Ready** للتوزيع

## 🚀 النشر للإنتاج

1. **إعداد الخادم**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **إعداد قاعدة البيانات**
```bash
php artisan migrate --force
php artisan db:seed --force
```

3. **إعداد التخزين**
```bash
php artisan storage:link
```

4. **إعداد البيئة**
- عدل `.env` للإنتاج
- أضف متغيرات البيئة
- أضف SSL certificate

## 📞 الدعم

لأي استفسارات أو مساعدة:
- **البريد الإلكتروني**: support@revira.com
- **الهاتف**: +966-11-123-4567
- **الموقع**: https://revira.com

## 📄 الرخصة

هذا المشروع مرخص تحت رخصة MIT. راجع ملف `LICENSE` للتفاصيل.

---

**تم تطوير هذا المشروع بواسطة فريق Revira Industrial** 🏭
