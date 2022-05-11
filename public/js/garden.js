(function () {
    'use strict';

    // document.body.style.cursor = "wait";

    const forms = document.getElementsByClassName("ground-form");
    // console.log(forms);

    const seedBox = document.getElementsByClassName("seed");
    console.log(seedBox);

    const waterTool = document.getElementById("water-tool");

    for (let i = 0; i < seedBox.length; i++) {
        seedBox[i].addEventListener("click", function () {
            for (let j = 0; j < forms.length; j++) {
                forms[j].action = "/proj/add";
                forms[j].method = "post";
                forms[j].elements["name"].value = seedBox[i].elements["name"].value;
                forms[j].elements["price"].value = seedBox[i].elements["price"].value;
            }
        });
    }

    waterTool.addEventListener("click", function () {
        for (let i = 0; i < forms.length; i++) {
            forms[i].action = "/proj/incrementGrowth";
            forms[i].method = "post";
        }
    });


})();
