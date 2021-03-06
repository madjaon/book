<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(!empty($postchaps))
        @foreach($postchaps as $value)
            <?php 
                $postslug = CommonQuery::getFieldById('posts', $value->post_id, 'slug');
            ?>
            <url>
                <loc>{{ url($postslug . '/' . $value->slug) }}</loc>
                <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif
</urlset>