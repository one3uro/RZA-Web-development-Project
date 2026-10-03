const images = [
    "../images/homepageimages/image1.jpg",
    "../images/homepageimages/image2.jpg",
    "../images/homepageimages/image3.jpg",
    "../images/homepageimages/image4.jpg"
];  

let currentIndex = 0;

const slideimg = document.getElementById("slideimg");
const pageNumbers = document.getElementById("pageNumbers");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

function renderSlideshow() {
    slideimg.src = images[currentIndex];
    slideimg.classList.remove("fade");
    void slideimg.offsetWidth;
    slideimg.classList.add("fade");

    pageNumbers.innerHTML = "";
    images.forEach((img, i) => {
        const link = document.createElement("a");
        link.href = "#";
        link.textContent = i + 1;
        link.className = "page" + (i === currentIndex ? " active" : "");
        link.addEventListener("click", (e) => {
            e.preventDefault();
            currentIndex = i;
            renderSlideshow();
        });
        pageNumbers.appendChild(link);
    });
}

prevBtn.addEventListener("click", (e) => {
    e.preventDefault();
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    renderSlideshow();
});

nextBtn.addEventListener("click", (e) => {
    e.preventDefault();
    currentIndex = (currentIndex + 1) % images.length;
    renderSlideshow();
});

renderSlideshow();

let lastScrollTop = 0;
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

// Scroll Down past top margin (50px threshold to avoid triggering immediately)
if (currentScroll > lastScrollTop && currentScroll > 50) {
    header.classList.add('header--hidden');
} else {
    // Scroll Up
    header.classList.remove('header--hidden');
}

lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
});