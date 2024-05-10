<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($prods as $prod)
        <url>
            <loc>https://ecpmarket.com/product/{{ $prod->slug }}</loc>
        </url>
    @endforeach
</urlset>
