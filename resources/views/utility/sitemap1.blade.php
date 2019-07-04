<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>always</changefreq>
        <priority>1</priority>
    </url>
    @if(!empty($posttypes))
        @foreach($posttypes as $value)
        <url>
        	<loc>{{ url('the-loai/' . $value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if(!empty($posttags))
        @foreach($posttags as $value)
        <url>
        	<loc>{{ url('tag/' . $value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if(!empty($postseries))
        @foreach($postseries as $value)
        <url>
            <loc>{{ url('chu-de/' . $value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endforeach
    @endif
</urlset>