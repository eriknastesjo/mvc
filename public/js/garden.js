(function () {
    'use strict';

    // prevents scrolling - otherwise page will act weird with followCursor function
    const body = document.getElementsByClassName("body-garden")[0];
    body.style.overflow = "hidden";

    const forms = document.getElementsByClassName("ground-form");
    const seedBox = document.getElementsByClassName("seed");

    const waterTool = document.getElementById("water-tool");

    for (let i = 0; i < seedBox.length; i++) {
        seedBox[i].addEventListener("click", function () {
            for (let j = 0; j < forms.length; j++) {

                const name = seedBox[i].elements["name"].value;
                const price = seedBox[i].elements["price"].value;

                forms[j].action = "/proj/add";
                forms[j].method = "post";
                forms[j].elements["name"].value = name;
                forms[j].elements["price"].value = price;

                followCursor.init();
                followCursor.changeCursor("../img/"+ name + "Seed" + ".png");
            }
        });
    }

    waterTool.addEventListener("click", function () {
        for (let i = 0; i < forms.length; i++) {
            forms[i].action = "/proj/incrementGrowth";
            forms[i].method = "post";
            followCursor.init();
            followCursor.changeCursor("../img/ToolWaterCan.png");
        }
    });

    let followCursor = (function () {
        let s = document.createElement("img");
        s.style.position = 'absolute';
        s.style.margin = '0';
        s.id = "cursor";

        return {
            init: function () {
                document.body.appendChild(s);
                const gardenContainer = document.getElementsByClassName("body-garden")[0];
                gardenContainer.style.cursor = "none";

                const disableCursor = document.getElementsByClassName("cursor-pointer");
                for (let i = 0; i < disableCursor.length; i++) {
                    disableCursor[i].style.cursor = "none";
                }
            },

            run: function (e) {
                e = e || window.event;
                s.style.left = (e.clientX - 15) + 'px';
                s.style.top = (e.clientY - 15) + 'px';
            },

            changeCursor: function (url) {
                s.src = url;
            }
        };
    }());

    document.body.onmousemove = followCursor.run;

})();
