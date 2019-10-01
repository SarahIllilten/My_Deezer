function httpGet(theUrl){
	console.log(theUrl);
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open( "GET", theUrl, false );
	xmlHttp.send( null );
	return xmlHttp.responseText;
}

function ListAlbum(){
	console.log("ListAlbum");
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=albums&action=get_albums_list'));
	console.log(data);
	var template = "<h1 onclick=getAlbum({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var album = document.getElementById('app');
		console.log(album);
		album.innerHTML=album.innerHTML+html;
	};
}

function searchalbum() {
	var inputalbum = document.getElementById('inputalbum').value;
	document.getElementById('app').innerHTML="";
	console.log("searchalbum");
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=albums&action=find_album&name='+inputalbum));
	console.log(data);
	var template = "<h1 onclick=getAlbum({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var album = document.getElementById('app');
		console.log(album);
		album.innerHTML=album.innerHTML+html;
	};
	
}

function searchgenre() {
	var inputgenre = document.getElementById('inputgenre').value;
	document.getElementById('app').innerHTML="";
	console.log("searchgenre");
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=genres&action=find_genre&name='+inputgenre));
	console.log(data);
	var template = "<h1 onclick=getAlbum({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var genre = document.getElementById('app');
		console.log(genre);
		genre.innerHTML=genre.innerHTML+html;
	};
}

function searchartist() {
	var inputartist = document.getElementById('inputartist').value;
	document.getElementById('app').innerHTML="";
	console.log("searchartist");
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=artists&action=find_artist&name='+inputartist));
	console.log(data);
	var template = "<h1 onclick=getArtist({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var artist = document.getElementById('app');
		console.log(artist);
		artist.innerHTML=artist.innerHTML+html;
	};
}

function displaySearch() {
	var template = "<div><input type=\"text\" id=\"inputalbum\" placeholder=\"album\"><button onclick=searchalbum()>Trouver Album</button></div>";
	template += "<div><input type=\"text\" id=\"inputgenre\" placeholder=\"genre\"><button onclick=searchgenre()>Trouver Genre</button></div>";
	template += "<div><input type=\"text\" id=\"inputartist\" placeholder=\"artist\"><button onclick=searchartist()>Trouver Artiste</button></div>";
	var app = document.getElementById('app');
	app.innerHTML = template;
}

function ListAléatoire(){
	console.log("ListAlbum");
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=albums&action=get_random_album'));
	console.log(data);
	var template = "<h1 onclick=getAlbum({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var aléatoire = document.getElementById('app');
		console.log(aléatoire);
		aléatoire.innerHTML=aléatoire.innerHTML+html;
	};
}

function ListArtist(){
	document.getElementById('app').innerHTML="";
	console.log("ListArist");
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=artists&action=get_artists_list'));
	console.log(data);
	var template = "<h1 onclick=getArtist({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var artist = document.getElementById('app');
		console.log(artist);
		artist.innerHTML=artist.innerHTML+html;
	};
}

function ListGenre(){
	document.getElementById('app').innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=genres&action=get_genres_list'));
	console.log(data);
	var template = "<h1 onclick=getGenre({{id}})>{{name}}</h1>";
	for (var element in data.result){
		var html = Mustache.to_html(template, data.result[element]);
		var genre = document.getElementById('app');
		genre.innerHTML=genre.innerHTML+html;
	};
}

function getAlbum(id) {
	console.log(id);
	var app = document.getElementById('app');
	app.innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=albums&action=get_album&id='+id));
	console.log(data);
	var template ="<h1>{{name}}</h1><p onclick=getArtist({{artist_id}})>{{artist_name}}</p><p>{{description}}</p><img src=\"{{cover}}\"><p>{{popularity}}</p><p>{{release_date}}</p><audio id=\"player\"controls src=\"#\">";
	var albumHtml = Mustache.to_html(template, data.result);
	app.innerHTML=app.innerHTML+albumHtml;
	app.innerHTML=app.innerHTML+"<div id=\"tracks\"></div>"
	var template_tracks="<button onclick=runPlayer(\"{{mp3}}\")>Play</button><div>{{name}}</div><div>{{duration}}</div><div>{{tracks_no}}</div>";
	for (var element in data.result.tracks){
		console.log('lol');
		var tracksHtml = Mustache.to_html(template_tracks, data.result.tracks[element]);
		var tracksDiv = document.getElementById('tracks')
		tracksDiv.innerHTML=tracksDiv.innerHTML+tracksHtml;
	};

}

function getArtist(id) {
	console.log(id);
	var app = document.getElementById('app');
	app.innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=artists&action=get_artist&id='+id));
	console.log(data);
	var template ="<p>{{description}}</p><p>{{bio}}</p><img src=\"{{photo}}\">";
	var artistHtml = Mustache.to_html(template, data.result);
	app.innerHTML=app.innerHTML+artistHtml;
	app.innerHTML=app.innerHTML+"<div id=\"album\"></div>"
	var templateAlbum ="<h1 onclick=getAlbum({{album_id}})>{{name}} </h1><p>{{description}}</p><img src=\"{{cover}}\"><p>{{popularity}}</p><p>{{release_date}}</p>";
	for (var element in data.result.albums){
		console.log(data.result.albums[element]);
		var albumHtml = Mustache.to_html(templateAlbum, data.result.albums[element]);
		var albumDiv = document.getElementById('album')
		albumDiv.innerHTML=albumDiv.innerHTML+albumHtml;
	};

}


function getGenre(id){
	console.log(id);
	var app = document.getElementById('app');
	app.innerHTML="";
	var data = JSON.parse(httpGet('http://localhost:8888/API_music/?controller=genres&action=get_genre&id='+id));
	console.log(data);
	var template ="<h1>{{name}}</h1>";
	var genreHtml = Mustache.to_html(template, data.result);
	app.innerHTML=app.innerHTML+genreHtml;
	app.innerHTML=app.innerHTML+"<div id=\"album\"></div>"
	var template_genre="<p>{{name}}</p>";
	for (var element in data.result.albums){
		console.log(data.result.albums[element]);
		var albumHtml = Mustache.to_html(template_genre, data.result.albums[element]);
		var albumDiv = document.getElementById('album')
		albumDiv.innerHTML=albumDiv.innerHTML+albumHtml;
	};
}

function runPlayer (mp3) {
	console.log('hello');
	var player = $('#player');
	console.log(player);
	player.attr('src', mp3);
}