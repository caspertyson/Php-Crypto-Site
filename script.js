if (window.XMLHttpRequest) {
xhttp = new XMLHttpRequest();
} else {    // IE 5/6
xhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xhttp.overrideMimeType('text/xml');

xhttp.open("GET", "test.xml", false);
xhttp.send(null);
xmlDoc = xhttp.responseXML;


let content = document.getElementById('Content');


function showCoin(div){
    content.innerHTML = "";


    for(i = 0; i < 31; i++){
        let coin = xmlDoc.getElementsByTagName("name")[i].childNodes[0].nodeValue;
        if(coin === div.childNodes[2].innerHTML){
            const coinImage = document.createElement('img')
            const name = document.createElement('p');
            const price = document.createElement('p');
            const fluctuation24 = document.createElement('p');
            const fluctuation7 = document.createElement('p');
            const marketCap = document.createElement('p');
            const volume24 = document.createElement('p');
            const description = document.createElement('p');
            const descriptionDiv = document.createElement('div');
            const coinContent = document.createElement('div');

            name.textContent = xmlDoc.getElementsByTagName("name")[i].childNodes[0].nodeValue;
            price.textContent = "$" + Number(xmlDoc.getElementsByTagName("price")[i].childNodes[0].nodeValue).toLocaleString()
            fluctuation24.textContent = xmlDoc.getElementsByTagName("fluctuation24h")[i].childNodes[0].nodeValue;
            fluctuation7.textContent = xmlDoc.getElementsByTagName("fluctuation7d")[i].childNodes[0].nodeValue;
            marketCap.textContent = "$" + Number(xmlDoc.getElementsByTagName("marketCap")[i].childNodes[0].nodeValue).toLocaleString();
            volume24.textContent = "$" + Number(xmlDoc.getElementsByTagName("volume24h")[i].childNodes[0].nodeValue).toLocaleString();
            description.textContent = xmlDoc.getElementsByTagName("description")[i].childNodes[0].nodeValue;
            coinImage.src = xmlDoc.getElementsByTagName("imgPath")[i].childNodes[0].nodeValue;
           
            if(fluctuation24.textContent <= 0){
                fluctuation24.id="OneDayDown"
                fluctuation24.innerHTML = "&#x25BC;" + fluctuation24.textContent + "%"
            }else{
                fluctuation24.id="OneDay"
                fluctuation24.innerHTML = "&#x25B2;" + fluctuation24.textContent + "%"
            }
            if(fluctuation7.textContent <= 0){
                fluctuation7.id="OneWeekDown"
                fluctuation7.innerHTML = "&#x25BC;" + fluctuation7.textContent + "%"
            }else{
                fluctuation7.id="OneWeek"
                fluctuation7.innerHTML = "&#x25B2;" + fluctuation7.textContent + "%"
            }

            coinImage.id ="CoinImage"
            name.id="CoinName"
            price.id="Price"
            marketCap.id="MarketCap"
            volume24.id="Volume24"
            coinContent.className="CoinContent"
            descriptionDiv.id = "description"
            coinContent.className="coinDetails"

            content.appendChild(coinContent)
            content.appendChild(descriptionDiv)

            coinContent.appendChild(coinImage)
            coinContent.appendChild(name)
            coinContent.appendChild(price)
            coinContent.appendChild(fluctuation24)
            coinContent.appendChild(fluctuation7)
            coinContent.appendChild(marketCap)
            coinContent.appendChild(volume24)

            descriptionDiv.appendChild(description)
        }
    }
}