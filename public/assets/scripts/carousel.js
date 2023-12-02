const controls = document.getElementsByClassName('control_movie');
const currentItems = {};

for (let control of controls) {
    const containerMovies = control.parentElement.querySelector('.container_movies')
    const sectionCategory = containerMovies.classList[1]
    currentItems[sectionCategory] = 0

    control.addEventListener('click', function() {
        moveSlide(control, containerMovies, sectionCategory)
    })
}

function moveSlide(control, containerMovies, sectionCategory) { 
    const boxMovies = containerMovies.querySelectorAll('.box_movie')
    
    checkSide(control.classList[1], sectionCategory)
    updateCurrentItem(sectionCategory, boxMovies.length / 2)
    
    const gap = (document.defaultView.getComputedStyle(containerMovies, null)['gap']).slice(0, -2)
    const sizeBoxMovie = (boxMovies[0].clientWidth + Math.round(gap))
    const widthToMove = (sizeBoxMovie * 2) * currentItems[sectionCategory]

    containerMovies.style.marginLeft = `-${widthToMove}px`;
}

function checkSide(sideClicked, sectionCategory) {
    switch(sideClicked) {
        case 'left':
            currentItems[sectionCategory]--
            break
        case 'right':
            currentItems[sectionCategory]++
            break
    }
} 

function updateCurrentItem(sectionCategory, moviesAmount) {
    let currentItem = currentItems[sectionCategory]

    if (currentItem <= 0) {
        currentItems[sectionCategory] = 0
    }

    if (currentItem >= moviesAmount) {
        currentItems[sectionCategory] = moviesAmount - 2
    }
}