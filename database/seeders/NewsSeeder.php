<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => [
                    'ar' => 'افتتاح معرض الآلات الصناعية 2024',
                    'en' => 'Industrial Machinery Exhibition 2024 Opening'
                ],
                'slug' => 'industrial-machinery-exhibition-2024',
                'summary' => [
                    'ar' => 'نشارك في معرض الآلات الصناعية 2024 مع أحدث منتجاتنا',
                    'en' => 'We participate in Industrial Machinery Exhibition 2024 with our latest products'
                ],
                'content' => [
                    'ar' => '<p>نفخر بالإعلان عن مشاركتنا في معرض الآلات الصناعية 2024 الذي سيعقد في الرياض خلال الفترة من 15 إلى 20 مارس 2024.</p>
                    <p>سيتم عرض أحدث منتجاتنا من الآلات والمعدات الصناعية، بما في ذلك:</p>
                    <ul>
                        <li>آلات CNC المتطورة</li>
                        <li>معدات النقل والرفع</li>
                        <li>أدوات القياس الدقيقة</li>
                        <li>معدات السلامة الصناعية</li>
                    </ul>
                    <p>نرحب بزيارتكم في جناحنا رقم B15 في المعرض.</p>',
                    'en' => '<p>We are proud to announce our participation in the Industrial Machinery Exhibition 2024, which will be held in Riyadh from March 15 to 20, 2024.</p>
                    <p>Our latest industrial machines and equipment will be displayed, including:</p>
                    <ul>
                        <li>Advanced CNC machines</li>
                        <li>Transportation and lifting equipment</li>
                        <li>Precision measuring tools</li>
                        <li>Industrial safety equipment</li>
                    </ul>
                    <p>We welcome you to visit our booth B15 at the exhibition.</p>'
                ],
                'image' => '/images/news-exhibition.svg',
                'author' => 'فريق التسويق',
                'source' => 'Revira Industrial',
                'tags' => ['معرض', 'صناعة', 'آلات'],
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'meta_title' => [
                    'ar' => 'افتتاح معرض الآلات الصناعية 2024 - Revira Industrial',
                    'en' => 'Industrial Machinery Exhibition 2024 Opening - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'نشارك في معرض الآلات الصناعية 2024 مع أحدث منتجاتنا',
                    'en' => 'We participate in Industrial Machinery Exhibition 2024 with our latest products'
                ]
            ],
            [
                'title' => [
                    'ar' => 'إطلاق خط إنتاج جديد للآلات الصناعية',
                    'en' => 'Launch of New Industrial Machinery Production Line'
                ],
                'slug' => 'new-industrial-machinery-production-line',
                'summary' => [
                    'ar' => 'أطلقنا خط إنتاج جديد للآلات الصناعية عالية الكفاءة',
                    'en' => 'We launched a new production line for high-efficiency industrial machinery'
                ],
                'content' => [
                    'ar' => '<p>نفخر بالإعلان عن إطلاق خط إنتاج جديد للآلات الصناعية عالية الكفاءة في مصنعنا الرئيسي.</p>
                    <p>يتميز الخط الجديد بـ:</p>
                    <ul>
                        <li>تقنيات تصنيع متطورة</li>
                        <li>مراقبة جودة دقيقة</li>
                        <li>كفاءة إنتاجية عالية</li>
                        <li>استهلاك طاقة منخفض</li>
                    </ul>
                    <p>هذا الإنجاز يعزز من قدرتنا على تلبية الطلب المتزايد على الآلات الصناعية عالية الجودة.</p>',
                    'en' => '<p>We are proud to announce the launch of a new production line for high-efficiency industrial machinery at our main factory.</p>
                    <p>The new line features:</p>
                    <ul>
                        <li>Advanced manufacturing technologies</li>
                        <li>Precise quality control</li>
                        <li>High production efficiency</li>
                        <li>Low energy consumption</li>
                    </ul>
                    <p>This achievement enhances our ability to meet the growing demand for high-quality industrial machinery.</p>'
                ],
                'image' => '/images/news-production-line.svg',
                'author' => 'فريق الإنتاج',
                'source' => 'Revira Industrial',
                'tags' => ['إنتاج', 'تقنية', 'كفاءة'],
                'is_active' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'meta_title' => [
                    'ar' => 'إطلاق خط إنتاج جديد للآلات الصناعية - Revira Industrial',
                    'en' => 'Launch of New Industrial Machinery Production Line - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'أطلقنا خط إنتاج جديد للآلات الصناعية عالية الكفاءة',
                    'en' => 'We launched a new production line for high-efficiency industrial machinery'
                ]
            ],
            [
                'title' => [
                    'ar' => 'شراكة استراتيجية مع شركة ألمانية رائدة',
                    'en' => 'Strategic Partnership with Leading German Company'
                ],
                'slug' => 'strategic-partnership-german-company',
                'summary' => [
                    'ar' => 'وقعنا شراكة استراتيجية مع شركة ألمانية رائدة في مجال الآلات الصناعية',
                    'en' => 'We signed a strategic partnership with a leading German industrial machinery company'
                ],
                'content' => [
                    'ar' => '<p>نفخر بالإعلان عن توقيع شراكة استراتيجية مع شركة ألمانية رائدة في مجال الآلات الصناعية.</p>
                    <p>هذه الشراكة ستوفر لنا:</p>
                    <ul>
                        <li>أحدث التقنيات الألمانية</li>
                        <li>دعم فني متقدم</li>
                        <li>تدريب مستمر للفريق</li>
                        <li>ضمان جودة ألماني</li>
                    </ul>
                    <p>هذا التعاون يعزز من قدرتنا على تقديم أفضل الحلول الصناعية لعملائنا.</p>',
                    'en' => '<p>We are proud to announce the signing of a strategic partnership with a leading German industrial machinery company.</p>
                    <p>This partnership will provide us with:</p>
                    <ul>
                        <li>Latest German technologies</li>
                        <li>Advanced technical support</li>
                        <li>Continuous team training</li>
                        <li>German quality guarantee</li>
                    </ul>
                    <p>This cooperation enhances our ability to provide the best industrial solutions for our customers.</p>'
                ],
                'image' => '/images/news-partnership.svg',
                'author' => 'فريق الإدارة',
                'source' => 'Revira Industrial',
                'tags' => ['شراكة', 'ألمانيا', 'تقنية'],
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(15),
                'meta_title' => [
                    'ar' => 'شراكة استراتيجية مع شركة ألمانية رائدة - Revira Industrial',
                    'en' => 'Strategic Partnership with Leading German Company - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'وقعنا شراكة استراتيجية مع شركة ألمانية رائدة في مجال الآلات الصناعية',
                    'en' => 'We signed a strategic partnership with a leading German industrial machinery company'
                ]
            ]
        ];

        foreach ($news as $newsData) {
            News::create($newsData);
        }
    }
}