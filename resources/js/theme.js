 // Retrieve
 var theme = localStorage.getItem("theme");

 console.log(theme);

 //to save the theme if forgot it
 if (theme == undefined) {
     // Set the default theme is light
     localStorage.setItem("theme", "light");
     loadTheThemeCSS("light");
 } else {
     loadTheThemeCSS(theme);
 }


 //change the theme , when we change the dropdown we execute this function
 function changeTheTheme(newVal) {
     //save the new theme
     localStorage.setItem("theme", newVal);
     //reload the page to load the selected theme
     window.location.reload();
 }


 function loadTheThemeCSS(themeName) {
     let link = document.createElement("link");
     link.href = "css/" + themeName + ".css";
     link.type = "text/css";
     link.rel = "stylesheet";

     document.getElementsByTagName("head")[0].appendChild(link);
 }