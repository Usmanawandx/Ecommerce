<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($categories as $category)
        <url>
            <loc>https://ecpmarket.com/category/{{ $category->slug }}</loc>
        </url>
         @foreach ($category->subs as $subs)
            <url>
                <loc>https://ecpmarket.com/category/{{ $category->slug }}/{{$subs->slug}}</loc>
            </url>
            @foreach ($subs->childs as $childs)
                <url>
                    <loc>https://ecpmarket.com/category/{{ $category->slug }}/{{$subs->slug}}/{{$childs->slug}}</loc>
                </url>
            @endforeach
         @endforeach
    @endforeach
</urlset>
