<!DOCTYPE html>
<html lang="en">


<?php
include 'styles.php';
?>
<style>
    #anboard-container {
        margin: 10px auto;
        width: 1400px;
    }

    #anboard {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 24px;
    }

    #anboard li {
        float: left;
        margin: 0 6px 6px 0;
        width: 70px;
        height: 70px;
        line-height: 70px;
        text-align: center;
        background: #000;
        color: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        -webkit-border-radius: 5px;
    }

    #anboard .delete {
        width: 300px;
    }

    .lastitem {
        margin-right: 0;
    }


    #anboard li:hover {
        position: relative;
        top: 1px;
        left: 1px;
        border-color: #e5e5e5;
        cursor: pointer;
    }
</style>

<body>
    <div class="full_container">
        <style>
            .ui_container {
                font-size: 22px;
                font-weight: bold;
            }
        </style>
        <script>
            function validateForm() {
                var epi = document.getElementById("epi").value.trim();
                var ppcm = document.getElementById("ppcm").value.trim();
                var width = document.getElementById("width").value.trim();

                var isValid = true;

                if (epi === "") {
                    document.getElementById("aepi").innerText = "This field is required";
                    isValid = false;
                } else {
                    document.getElementById("aepi").innerText = "";
                }

                if (ppcm === "") {
                    document.getElementById("appcm").innerText = "This field is required";
                    isValid = false;
                } else {
                    document.getElementById("appcm").innerText = "";
                }

                if (width === "") {
                    document.getElementById("awidth").innerText = "This field is required";
                    isValid = false;
                } else {
                    document.getElementById("awidth").innerText = "";
                }

                return isValid;
            }
        </script>
       <form method="post" action="home.php">
            <div class="col-md-2 col-sm-6">
                <div class="form-group">
                    <label class="control-label">EPI : <span id="aepi" style="color:red ; padding-right: 40px;"></span></label>
                    <input type="text" class="form-control focus" name="epi" id="epi" placeholder="EPI" onclick="updateCurrentIndex(0)">
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="form-group">
                    <label class="control-label">PPI : <span id="appcm" style="color:red"></span></label>
                    <input type="text" class="form-control focus" name="ppcm" id="ppcm" placeholder="PPCM" onclick="updateCurrentIndex(1)">
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="form-group">
                    <label class="control-label">Width : <span id="awidth" style="color:red"></span></label>
                    <input type="text" class="form-control focus" name="width" id="width" placeholder="WIDTH" onclick="updateCurrentIndex(2)">
                </div>
            </div>
            <div class="col-6" style="margin-top: 10px;">
                <h6 style="color:#FFFFFF">
                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                </h6>
            </div>
        </form>


        <div class="col-md-8 col-sm-12"><br>
            <div id="anboard-container">
                <ul id="anboard">
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">1</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">2</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">3</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">4</li>
                    <li class="symbol lastitem"onclick="addValueAndMoveFocus(this)">5</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">6</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">7</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">8</li>
                    <li class="symbol"onclick="addValueAndMoveFocus(this)">9</li>
                    <li class="symbol lastitem"onclick="addValueAndMoveFocus(this)">0</li>

                    <li class="letter"onclick="addValueAndMoveFocus(this)">A</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">B</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">C</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">D</li>
                    <li class="letter lastitem"onclick="addValueAndMoveFocus(this)">E</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">F</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">G</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">H</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">I</li>
                    <li class="letter lastitem"onclick="addValueAndMoveFocus(this)">J</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">K</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">L</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">M</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">N</li>
                    <li class="letter lastitemonclick="addValueAndMoveFocus(this)"">O</li>
                    <li class="letter" onclick="addValueAndMoveFocus(this)">P</li>
                    <li class="letter" onclick="addValueAndMoveFocus(this)">Q</li>
                    <li class="letter" onclick="addValueAndMoveFocus(this)">R</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">S</li>
                    <li class="letter lastitem" onclick="addValueAndMoveFocus(this)">T</li>
                    <li class="letter" onclick="addValueAndMoveFocus(this)">U</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">V</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">W</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">X</li>
                    <li class="letter lastitem"onclick="addValueAndMoveFocus(this)">Y</li>
                    <li class="letter"onclick="addValueAndMoveFocus(this)">Z</li>
                    <li class="delete" onclick="deleteValueAndMoveFocus()">DELETE</li>
                    <li class="enter" onclick="moveToNextField()">Enter</li>
                </ul>
            </div>
        </div>

       <script>
            var currentFieldIndex = 0;
        var inputFields = ['epi', 'ppcm', 'width'];

        function moveOnEnter(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                moveToNextField();
            }
        }
        function deleteValueAndMoveFocus() {
            var fieldValue = document.getElementById(inputFields[currentFieldIndex]).value;
            if (fieldValue.length > 0) {
                // Delete the last character
                fieldValue = fieldValue.substring(0, fieldValue.length - 1);
                document.getElementById(inputFields[currentFieldIndex]).value = fieldValue;
            }
        }

        function addValueAndMoveFocus(button) {
            var value = button.textContent;
            document.getElementById(inputFields[currentFieldIndex]).value += value;
            document.getElementById(inputFields[currentFieldIndex]).focus();
        }

        function moveToNextField() {
            if (currentFieldIndex < inputFields.length - 1) {
                currentFieldIndex++;
                document.getElementById(inputFields[currentFieldIndex]).focus();
            }
        }
        function updateCurrentIndex(index) {
            currentFieldIndex = index;
        }
       </script>
        

    </div>
</body>
</html>

