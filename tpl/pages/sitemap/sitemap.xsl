<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="xml"/>
    <xsl:template match="/">
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>http://www.example.com/</loc>
                <lastmod>2005-01-01</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>
        </urlset>
    </xsl:template>
</xsl:stylesheet>
