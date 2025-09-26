@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($items as $job)
        <url>
            <loc>{{ url(route('job_postings.show', ['slug' => $job->slug], false)) }}</loc>
            <lastmod>{{ $job->updated_at->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
