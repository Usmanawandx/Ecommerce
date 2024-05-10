<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($stores as $store)
        <url>
            <loc>https://ecpmarket.com/store/{{ $store->shop_slug }}</loc>
        </url>
    @endforeach
</urlset>
