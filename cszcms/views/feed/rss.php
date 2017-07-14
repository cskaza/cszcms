<?php header('Content-Type: '.$ctype.'; charset='.$charset); 
/**
 * Feed generator class for ci-feed library.
 *
 * @author Roumen Damianoff <roumen@dawebs.com>
 * @version 1.3.3
 * @link http://roumen.it/projects/ci-feed
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"<?php foreach($namespaces as $n) echo " ".$n; ?>>
    <channel>
        <title><?php echo $channel['title'] ?></title>
        <link><?php echo $channel['link'] ?></link>
        <atom:link href="<?php echo current_url() ?>" rel="self" type="application/rss+xml" />
        <description><?php echo $channel['description'] ?></description>     
        <lastBuildDate><?php echo $channel['pubdate'] ?></lastBuildDate>
        <generator>CSZ CMS</generator>
        <?php foreach($items as $item) : ?>
        <item>
            <title><?php echo $item['title'] ?></title>
            <link><?php echo $item['link'] ?></link>
            <guid isPermaLink="true"><?php echo $item['link'] ?></guid>
            <description><![CDATA[<?php echo $item['description'] ?>]]></description>
            <pubDate><?php echo $item['pubdate'] ?></pubDate>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>