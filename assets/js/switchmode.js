try {
    function setTheme(theme) {
        localStorage.setItem("theme", theme);
        console.log(theme);
        if(theme === "dark"){
            $("body").attr("data-mdb-theme", "dark");
            $('.logd').attr('src', '../assets/images/logo-light.png');
            $('.bl').show();
            $('.bd').hide();
            $('#main-navbar').removeClass("navbar-light bg-light");
            $('#main-navbar').addClass("navbar-dark bg-dark");
        }else{
            $("body").attr("data-mdb-theme", "light");
            $('.logd').attr('src', '../assets/images/logo-dark.png');
            $('.bl').hide();
            $('.bd').show();
            $('#main-navbar').removeClass("navbar-dark bg-dark");
            $('#main-navbar').addClass("navbar-light bg-light");
        }
    };

    function loadTheme(){
        if(!localStorage.getItem("theme")){
            //Checking if the default browser theme is light
            if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
            	$("body").attr("data-mdb-theme", "dark");
                $('.bl').show();
                $('.bd').hide();
                $('#main-navbar').removeClass("navbar-light bg-light");
                $('#main-navbar').addClass("navbar-dark bg-dark");
                $(".logd").attr('src', '../assets/images/logo-light.png');
            }else{
                $("body").attr("data-mdb-theme", "light");
                $('.bl').hide();
                $('.bd').show();
                $('#main-navbar').removeClass("navbar-dark bg-dark");
                $('#main-navbar').addClass("navbar-light bg-light");
                $(".logd").attr('src', '../assets/images/logo-dark.png');
            }
        }else{
            let GetTheme = localStorage.getItem("theme");
            if(GetTheme === "dark"){
            	$("body").attr("data-mdb-theme", "dark");
                $('.bl').show();
                $('.bd').hide();
                $('#main-navbar').removeClass("navbar-light bg-light");
                $('#main-navbar').addClass("navbar-dark bg-dark");
                $(".logd").attr('src', '../assets/images/logo-light.png');
            }else{
                $("body").attr("data-mdb-theme", "light");
                $('.bl').hide();
                $('.bd').show();
                $('#main-navbar').removeClass("navbar-dark bg-dark");
                $('#main-navbar').addClass("navbar-light bg-light");
                $(".logd").attr('src', '../assets/images/logo-dark.png');
            }
        }
    }
    loadTheme();
} catch (error) {
    console.log("dark");
}