<html>
    <head>
        <title>Chart</title>
        <style>
            .chartbody { 
                width: 90%;    
                height: 250px;
                border: 2px solid #333;
                background: #EEE;
                margin: 20px auto;
                padding: 20px;
            }
            .chartcontain {
                width: 100%;    
                height: 250px;
                text-align: center;
            }
            .barref { 
                display: inline-block;
                width: 1px;    
                height: 100%;
                vertical-align: bottom;
            }            
            .bardata { 
                display: inline-block;
                width: 80px;  
                margin: 0px auto;
                vertical-align: bottom;
            }         
            .bar { 
                width: 40px;    
                background: #03295A;
                margin: 0px auto;
                vertical-align: bottom;
            }
            .barname {
                width: 80px;
                height: 40px;
                margin: 10px auto 0px auto;
                text-align: center;
                font-family: "Verdana";
                font-size: 11px;
                clear: both;
            }
        </style>
    </head>
    <body>
        <div class="chartbody">
            <div class="chartcontain">                
                <div class="barref">&nbsp;</div>
                <div class="bardata">
                    <div class="bar" style="height: 50%;">&nbsp;</div>
                    <div class="barname">Data 1</div>
                </div>
                <div class="bardata">
                    <div class="bar" style="height: 90%;">&nbsp;</div>
                    <div class="barname">Data Data Data Data</div>
                </div>
            </div>
        </div>
    </body>
</html>