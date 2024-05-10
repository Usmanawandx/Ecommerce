<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($brands as $brand)
        <url>
            <loc>https://ecpmarket.com/brand/{{ $brand->slug }}</loc>
        </url>
    @endforeach
</urlset>
