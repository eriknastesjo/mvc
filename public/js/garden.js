(function () {
    'use strict';

    // document.body.style.cursor = "wait";

    const forms = document.getElementsByClassName("groundForm");
    // console.log(forms);

    const seedBox = document.getElementsByClassName("seed");
    console.log(seedBox);

    for (let i = 0; i < seedBox.length; i++) {
        seedBox[i].addEventListener("click", function (event) {
            for (let i = 0; i < forms.length; i++) {
                forms[i].action = "/proj/add";

                // forms[i].addEventListener("click", function (event) {

                // });
            }
        });
    }


})();
