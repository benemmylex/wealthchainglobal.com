try {
  function setTheme(theme) {
    localStorage.setItem("theme", theme);
    localStorage.setItem("hidebal", "shown");
    if (theme === "dark") {
      $("body").attr("data-mdb-theme", "dark");
      // $("body").removeClass("bg-light");
      // $("body").addClass("bg-dark");
      $("#navbar-brand").attr("src", "./assets/images/logo-white.png");
      $(".bl").show();
      $(".bd").hide();
    } else {
      $("body").attr("data-mdb-theme", "light");
      // $("body").removeClass("bg-dark");
      // $("body").addClass("bg-light");
      $("#navbar-brand").attr("src", "./assets/images/logo-black.png");
      $(".bl").hide();
      $(".bd").show();
    }
  }

  function loadTheme() {
    if (!localStorage.getItem("theme")) {
      //Checking if the default browser theme is light
      if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
      ) {
        $("body").attr("data-mdb-theme", "dark");
        $(".bl").show();
        $(".bd").hide();
        $("#navbar-brand").attr("src", "./assets/images/logo-white.png");
        // $("body").removeClass("bg-light");
        // $("body").addClass("bg-dark");
        console.log("l4dark");
      } else {
        $("body").attr("data-mdb-theme", "light");
        // $("body").removeClass("bg-dark");
        // $("body").addClass("bg-light");
        $(".bl").hide();
        $(".bd").show();
        $("#navbar-brand").attr("src", "./assets/images/logo-black.png");
        console.log("l3dark");
      }
    } else {
      let GetTheme = localStorage.getItem("theme");
      if (GetTheme === "dark") {
        $("body").attr("data-mdb-theme", "dark");
        $(".bl").show();
        $(".bd").hide();
        $("#navbar-brand").attr("src", "./assets/images/logo-white.png");
        // $("body").removeClass("bg-light");
        // $("body").addClass("bg-dark");
        console.log("l2dark");
      } else {
        $("body").attr("data-mdb-theme", "light");
        // $("body").removeClass("bg-dark");
        // $("body").addClass("bg-light");
        $(".bl").hide();
        $(".bd").show();
        $("#navbar-brand").attr("src", "./assets/images/logo-black.png");
        console.log("l1dark");
      }
    }
    const themeStitcher = document.getElementById("themingSwitcher");
    const isSystemThemeSetToDark =
      window.matchMedia("(prefers-color-scheme: dark)").matches &&
      localStorage.getItem("theme") == "dark";

    // set toggler position based on system theme
    if (isSystemThemeSetToDark) {
      themeStitcher.checked = true;
    }

    // add listener to theme toggler
    themeStitcher.addEventListener("change", (e) => {
      toggleTheme(e.target.checked);
    });

    const toggleTheme = (isChecked) => {
      const theme = isChecked ? "dark" : "light";
      setTheme(theme);
    };

    // add listener to toggle theme with Shift + D
    document.addEventListener("keydown", (e) => {
      if (e.shiftKey && e.key === "D") {
        themeStitcher.checked = !themeStitcher.checked;
        toggleTheme(themeStitcher.checked);
      }
    });
  }
  loadTheme();
} catch (error) {
  console.log("dark");
}
