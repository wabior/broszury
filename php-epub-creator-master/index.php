<?php
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

// The class is in the folder classes
require 'classes/TPEpubCreator.php';

$epub = new TPEpubCreator();

// config
$epub->temp_folder = 'temp/';
$epub->epub_file = 'ebooks/wfirma_tabele2.epub';

// E-book configs
$epub->title = 'wfirma jaro tabelki';
$epub->creator = 'Jarosław Wabich';
$epub->language = 'pl';
$epub->rights = 'Public Domain';
$epub->publisher = 'http://jarek.pl/';

// You can specity your own CSS
$epub->css = file_get_contents('base.css');

$epub->uuid = '';  // You can specify your own uuid

// Add page from file (just the <body> content)
// You have to remove doctype, head and body tags
// Sintax: $epub->AddPage( XHTML, file, title, download images );
//$epub->AddPage( false, 'file.txt', 'Título (check accent)' );
$epub->AddPage( false, 'file.html', 'Artykuł 1' );

// Add page content directly (just the <body> content)
// You must not use doctype, head and body tags (only XHTML body content)
//$epub->AddPage( '<b>Test</b>', false, 'Title 2' );
$epub->AddPage( false, 'file2.html', 'Artykuł 2' );
//$epub->AddPage( '<img src="images/banner.png" />', false, 'Title 3' );

// Here the last param tells the class to download de image
//$epub->AddPage( '<img src="images/3.jpg" />', false, 'Title 4', true );

//$epub->AddPage( '<img src="images/4.jpg" />', false, 'Title 5' );

$epub->AddImage( 'images/banner.png', false, false );


// Add image cover
// Make sure only one image is set to cover (last argument = true).
// If more than one image is set to cover, readers would not load the e-book.
// Sintax: $epub->AddImage( image path, mimetype, cover );
$epub->AddImage( 'images/1.jpg', false, true );

// Add another images (last arg is set to false - not cover - remember that)
$epub->AddImage( 'images/2.jpg', 'image/jpeg', false );

// If you don't send the mimetype, the class will try to get it from the file
$epub->AddImage( 'images/4.jpg', false, false );

// Create the EPUB
// If there is some error, the epub file will not be created
if ( ! $epub->error ) {

    // Since this can generate new errors when creating a folder
    // We'll check again
    $epub->CreateEPUB();
    
    // If there's no error here, you're e-book is successfully created
    if ( ! $epub->error ) {
        echo 'Success: Download your book <a href="' . $epub->epub_file . '">here</a>.';
    }
    
} else {
    // If for some reason you're e-book hasn't been created, you can see whats
    // going on
    echo $epub->error;
}
