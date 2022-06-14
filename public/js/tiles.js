




//////////////galerie photo tiles
let image = document.getElementById('image');
let images = document.getElementById('images');
let pres = document.getElementById('pres');


images.innerHTML = "<img src='/images/tiles/image1.jpg' alt='photo_tiles' class='m-1'>";
images.innerHTML += "<img src='/images/tiles/image2.jpg' alt='photo_tiles' class='border border-danger border-2 m-1'>";
images.innerHTML += "<img src='/images/tiles/image3.jpg' alt='photo_tiles' class='m-1'>";

image.innerHTML = "<img src='/images/tiles/image2.jpg' alt='photo_tiles' class='zoom m-3'>";

let i = 1;
pres.addEventListener('click', function(){
    i--;
    if(i < 1){
        i = 3;
    }
    images.innerHTML = "<img src='/images/tiles/image"+i+".jpg' alt='photo_tiles' class='m-1'>";
    images.innerHTML += "<img src='/images/tiles/image"+(i+1)+".jpg' alt='photo_tiles' class='border border-danger border-2 m-1'>";
    images.innerHTML += "<img src='/images/tiles/image"+(i+2)+".jpg' alt='photo_tiles' class='m-1'>";

    image.innerHTML = "<img src='/images/tiles/image"+(i+1)+".jpg' alt='photo_tiles' class='zoom m-3'>";
    
})
let suiv = document.getElementById('suiv');
suiv.addEventListener('click', function(){
    i++;
    
    if(i>3){
        i = 1;
    }
    
    
    images.innerHTML = "<img src='/images/tiles/image"+i+".jpg' alt='photo_tiles' class='m-1'>";
    images.innerHTML += "<img src='/images/tiles/image"+(i+1)+".jpg' alt='photo_tiles' class='border border-danger border-2 m-1' >";
    images.innerHTML += "<img src='/images/tiles/image"+(i+2)+".jpg' alt='photo_tiles' class='m-1'>";
    image.innerHTML = "<img src='/images/tiles/image"+(i+1)+".jpg' alt='photo_tiles' class='zoom m-3'>";
})

//////////////////////////////




    

    

