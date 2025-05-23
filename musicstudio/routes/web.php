<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'secure'], function () {
    Route::get('update', 'UpdateController@show');
    Route::post('update/run', 'UpdateController@update');

    //search
    Route::get('search/audio/{artist}/{track}', 'SearchController@searchAudio');
    Route::get('search/local/artists/{query}', 'SearchController@searchLocalArtists');
    Route::get('search/{query}', 'SearchController@index');

    //albums
    Route::get('albums', 'AlbumController@index');
    Route::post('albums', 'AlbumController@store');
    Route::put('albums/{id}', 'AlbumController@update');
    Route::delete('albums', 'AlbumController@destroy');
    Route::get('albums/popular', 'PopularAlbumsController@index');
    Route::get('albums/new-releases', 'NewReleasesController@index');
    Route::get('albums/{id}', 'AlbumController@show');

    //artists
    Route::get('artists', 'ArtistController@index');
    Route::post('artists', 'ArtistController@store');
    Route::put('artists/{id}', 'ArtistController@update');
    Route::get('artists/{nameOrId}', 'ArtistController@show');
    Route::get('artists/{id}/albums', 'ArtistAlbumsController@index');
    Route::delete('artists', 'ArtistController@destroy');
    
    //tracks
    Route::get('tracks', 'TrackController@index');
    Route::get('tracks/{id}/download', 'DownloadLocalTrackController@download');
    Route::post('tracks', 'TrackController@store');
    Route::put('tracks/{id}', 'TrackController@update');
    Route::get('tracks/top', 'TopTracksController@index');
    Route::get('tracks/{id}', 'TrackController@show');
    Route::delete('tracks', 'TrackController@destroy');
    Route::post('tracks/{id}/plays/increment', 'TrackPlaysController@increment');

    //LYRICS
    Route::get('lyrics', 'LyricsController@index');
    Route::post('lyrics', 'LyricsController@store');
    Route::delete('lyrics', 'LyricsController@destroy');
    Route::get('tracks/{id}/lyrics', 'LyricsController@show');
    Route::put('lyrics/{id}', 'LyricsController@update');

    //RADIO
    Route::get('radio/artist/{id}', 'ArtistRadioController@getRecommendations');
    Route::get('radio/track/{id}', 'TrackRadioController@getRecommendations');

    //GENRES
    Route::get('genres', 'GenreController@index');
    Route::post('genres', 'GenreController@store');
    Route::put('genres/{id}', 'GenreController@update');
    Route::delete('genres', 'GenreController@destroy');
    Route::get('genres/popular', 'PopularGenreController@index');
    Route::get('genres/{name}', 'GenreController@show');

    //USER LIBRARY
    Route::post('user/library/tracks/add', 'UserLibrary\UserLibraryTracksController@add');
    Route::post('user/library/tracks/remove', 'UserLibrary\UserLibraryTracksController@remove');
    Route::get('user/library/tracks', 'UserLibrary\UserLibraryTracksController@index');
    Route::get('user/library/albums', 'UserLibrary\UserLibraryAlbumsController@index');
    Route::get('user/library/artists', 'UserLibrary\UserLibraryArtistsController@index');

    //USER FOLLOWERS
    Route::post('users/{id}/follow', 'UserFollowersController@follow');
    Route::post('users/{id}/unfollow', 'UserFollowersController@unfollow');

    //PLAYLISTS
    Route::get('playlists/{id}', 'PlaylistController@show');
    Route::get('playlists', 'PlaylistController@index');
    Route::get('user/{id}/playlists', 'UserPlaylistsController@index');
    Route::put('playlists/{id}', 'PlaylistController@update');
    Route::post('playlists', 'PlaylistController@store');
    Route::delete('playlists', 'PlaylistController@destroy');
    Route::post('playlists/{id}/follow', 'UserPlaylistsController@follow');
    Route::post('playlists/{id}/unfollow', 'UserPlaylistsController@unfollow');
    Route::get('playlists/{id}/tracks', 'PlaylistTracksController@index');
    Route::post('playlists/{id}/tracks/add', 'PlaylistTracksController@add');
    Route::post('playlists/{id}/tracks/remove', 'PlaylistTracksController@remove');
    Route::post('playlists/{id}/tracks/order', 'PlaylistTracksOrderController@change');

    //EMAIL
    Route::post('media-items/links/send', 'EmailMediaItemLinksController@send');

    //ADMIN
    //Route::get('admin/error-log', 'AdminController@getErrorLog');
    Route::post('admin/sitemap/generate', 'SitemapController@generate');
});

//LEGACY
Route::get('track/{id}/{mime}/stream', 'TrackStreamController@stream');

//FRONT-END ROUTES THAT NEED TO BE PRE-RENDERED
Route::get('/', '\Common\Core\Controllers\HomeController@show')->middleware('prerenderIfCrawler');
Route::get('artist/{name}', 'ArtistController@show')->middleware('prerenderIfCrawler');
Route::get('artist/{id}/{name}', 'ArtistController@show')->middleware('prerenderIfCrawler');
Route::get('album/{albumId}/{artistId}/{albumName}', 'AlbumController@show')->middleware('prerenderIfCrawler');
Route::get('track/{id}', 'TrackController@show')->middleware('prerenderIfCrawler');
Route::get('track/{id}/{name}', 'TrackController@show')->middleware('prerenderIfCrawler');
Route::get('playlists/{id}', 'PlaylistController@show')->middleware('prerenderIfCrawler');
Route::get('playlists/{id}/{name}', 'PlaylistController@show')->middleware('prerenderIfCrawler');
Route::get('user/{id}', '\Common\Auth\Controllers\UserController@show')->middleware('prerenderIfCrawler');
Route::get('user/{id}/{name}', '\Common\Auth\Controllers\UserController@show')->middleware('prerenderIfCrawler');
Route::get('genre/{name}', 'GenreController@show')->middleware('prerenderIfCrawler');
Route::get('new-releases', 'NewReleasesController@index')->middleware('prerenderIfCrawler');
Route::get('popular-genres', 'PopularGenreController@index')->middleware('prerenderIfCrawler');
Route::get('popular-albums', 'PopularAlbumsController@index')->middleware('prerenderIfCrawler');
Route::get('top-50', 'TopTracksController@index')->middleware('prerenderIfCrawler');
Route::get('search/{query}', 'SearchController@index')->middleware('prerenderIfCrawler');
Route::get('search/{query}/{tab}', 'SearchController@index')->middleware('prerenderIfCrawler');

//CATCH ALL ROUTES AND REDIRECT TO HOME
Route::get('{all}', '\Common\Core\Controllers\HomeController@show')->where('all', '.*');
