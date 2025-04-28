<?php
/**
 * Parse RSS
 *
 * @package daily-pleroma.php
 */

function parse_pleroma_atom( $url ){
	$atom = new SimpleXMLElement( $url, LIBXML_COMPACT | LIBXML_NOERROR, true );

	foreach( $atom->entry as $entry ){
		$date = new DateTime( $entry->published );
		$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
		$key = $date->format( 'c' );
		
		foreach ( $entry->link as $link ){
			if( 'text/html' === (string) $link['type'] ){
				$url = (string) $link['href'];
				break;
			};
		}

		$items[ $key ] = array(
			'link' => $url,
			'content' => (string) $entry->content,
		);
	}

	return $items;
}

function build_post_main_content( $date = null ){

	$all_items = parse_pleroma_atom( 'https://autumnsky.jp/users/akiya/feed.atom' );
	$yesterday = new DateTime( '-1 day' );

	$items = array_filter( $all_items, function( $k ) use ( $yesterday ){
		return str_contains( $k, $yesterday->format( 'Y-m-d' ) );
	}, ARRAY_FILTER_USE_KEY );


	$content = '';
	foreach( $items as $time => $item ){
		$content .= <<< EOF
			<!-- wp:paragraph -->
			<p>{$item['content']} <a href="{$item['link']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	echo($content);
}
