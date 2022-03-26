const themeToggler = document.querySelector(".theme-toggler");

// change theme

if(sessionStorage.getItem("theme") == "dark") {
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
}

themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');

    if(sessionStorage.getItem("theme") == "dark") {
        sessionStorage.setItem("theme", "light");
    } else {
        sessionStorage.setItem("theme", "dark");
    }
})