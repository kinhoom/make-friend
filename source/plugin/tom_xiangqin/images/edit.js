 function birthchange() {

        var birthdate = $("#birthday").val();
        $("#xingzuo_id option:checked").attr("selected", "");
        if (birthdate.substring(5, 10) >= "01-20" && birthdate.substring(5, 10) <= "02-18") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 26) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "02-19" && birthdate.substring(5, 10) <= "03-20") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 27) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "03-21" && birthdate.substring(5, 10) <= "04-19") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 17) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "04-20" && birthdate.substring(5, 10) <= "05-20") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 18) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "05-21" && birthdate.substring(5, 10) <= "06-21") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 19) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "06-22" && birthdate.substring(5, 10) <= "07-22") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 20) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "07-23" && birthdate.substring(5, 10) <= "08-22") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 21) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "08-23" && birthdate.substring(5, 10) <= "09-22") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 22) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "09-23" && birthdate.substring(5, 10) <= "10-23") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 111) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "10-24" && birthdate.substring(5, 10) <= "11-22") {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 23) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (birthdate.substring(5, 10) >= "11-23" && birthdate.substring(5, 10) <= "12-21") {
            obj = document.getElementById("xqUserxz");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 24) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if ((birthdate.substring(5, 10) >= "12-22" && birthdate.substring(5, 10) <= "12-31") || (birthdate.substring(5, 10) >= "01-01" && birthdate.substring(5, 10) <= "01-19")) {
            obj = document.getElementById("xingzuo_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 25) {
                    obj[ii].selected = "selected";
                }

            }
        }




        $("#shuxiang_id option:checked").attr("selected", "");
        //
        var x = (1901 - birthdate.substring(0, 4)) % 12;
        //alert(x);
        if (x == 1 || x == -11) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 1) {
                    obj[ii].selected = "selected";

                }

            }
        }
        if (x == 0) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 2) {
                    obj[ii].selected = "selected";
                }
            }
            
        }
        if (x == 11 || x == -1) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 3) {
                    obj[ii].selected = "selected";
                }
            }
        }
        if (x == 10 || x == -2) {
            obj1 = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj1.length; ii++) {
                if (obj1[ii].value == 4) {
                    obj1[ii].selected = "selected";
                }

            }
        }
        if (x == 9 || x == -3) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 5) {
                    obj[ii].selected = "selected";
                }

            }
        }
        //
        if (x == 8 || x == -4) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 6) {
                    obj[ii].selected = "selected";
                }

            }
        }
        //
        if (x == 7 || x == -5) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 7) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (x == 6 || x == -6) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 8) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (x == 5 || x == -7) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 9) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (x == 4 || x == -8) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 10) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (x == 3 || x == -9) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 11) {
                    obj[ii].selected = "selected";
                }

            }
        }
        if (x == 2 || x == -10) {
            obj = document.getElementById("shuxiang_id");
            for (ii = 0; ii < obj.length; ii++) {
                if (obj[ii].value == 12) {
                    obj[ii].selected = "selected";
                }

            }


        }

    }
