document.querySelector('#sideNavButton').addEventListener('click', event => {
    document.querySelector('#sideNavButton').classList.toggle("active");
    document.querySelector('body').classList.toggle("active");
    document.querySelector('.sidenav').classList.toggle("active");
});

