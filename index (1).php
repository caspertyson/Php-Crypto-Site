
<?php
    // Report all errors
    ini_set("error_reporting",E_ALL);
    function display($j, $market){
        for($i=0;$i<$j;$i++){
            $item=$market[$i];

            $Price = number_format((float)$item->price, 2);
            $MarketCap = number_format((float)$item->marketCap);
            $Volume = number_format((float)$item->volume24h);

            $p = $i + 1;
            echo '<div id="$coinName" class="CoinContent" onClick=showCoin(this)>';
            echo '<p id="index">';
            echo "$p</p>";         
            echo '<img id="CoinImage"';
            echo "src=$item->imgPath  width=200 height=200>";
            echo '<p id="CoinName" name="SearchBar">';
            echo "$item->name<p>";
            echo '<p id="Price">';
            echo "$$Price<p>";
            if($item->fluctuation24h <= 0){
                echo '<p id="OneDayDown">';
                echo "&#x25BC;$item->fluctuation24h%<p>";
            }else{
                echo '<p id="OneDay">';
                echo "&#x25B2;$item->fluctuation24h%<p>";
            }
            if($item->fluctuation7d >= 0){
                echo '<p id="OneWeek">';
                echo "&#x25B2;$item->fluctuation7d%<p>";
            }
            else{
                echo '<p id="OneWeekDown">';
                echo "&#x25BC;$item->fluctuation7d%<p>";
            }

            echo '<p id="MarketCap">';
            echo "$$MarketCap<p>";
            echo '<p id="Volume24">';
            echo "$$Volume<p></div>";
        }
    }
    function displayCoin(){
        echo "<h1>displayCoin</h1>";
    }
?>
<!Doctype>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script defer src="script.js"></script>
    </head>
    <body>
        <?php
        $nameSort=true;
            class CryptoCoin{
               public $name;
               public $price;
               public $imgPath;
               public $description;
               public $fluctuation24h;
               public $fluctuation7d;
               public $marketCap;
               public $volume24h;
                function __construct( $name, $price, $imgPath, $description, $fluctuation24h , $fluctuation7d , $marketCap , $volume24h){
                    $this->name=$name;
                    $this->price=$price;
                    $this->imgPath=$imgPath;
                    $this->description=$description;
                    $this->fluctuation24h=$fluctuation24h;
                    $this->fluctuation7d=$fluctuation7d;
                    $this->marketCap=$marketCap;
                    $this->volume24h=$volume24h;
                }
            }

            $market=array();
            
            $xml = simplexml_load_file('test.xml');
            foreach($xml->children() as $unit){
                
                $myCoin = new CryptoCoin($unit->name,
                                        $unit->price,
                                        $unit->imgPath,
                                        $unit->description,
                                        $unit->fluctuation24h,
                                        $unit->fluctuation7d,
                                        $unit->marketCap,
                                        $unit->volume24h);
                array_push($market, $myCoin);
            }
            $name=$xml->getName();
       ?>
        <div id="Container">
                <div id="Header">
                    <div id="Logo">
                        <img id="logoImage" src="./Images/Logo.png" alt="">
                    </div>
                    <div id="Title">
                        <img src="./Images/Title.png" alt="">
                    </div>
                    <div id="Taskbar">
                        <div id="taskbarContainer">
                            <form class="TaskText" name="Name_Order" id="nameTitle" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <button type="submit" name="name" class="taskbarButtons"> Name </button>
                            </form>                            
                            <form class="TaskText" id="priceTitle" name="Price_Descending" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <button type="submit" name="price" class="taskbarButtons"> Price </button>
                            </form>
                            <div class="TaskText" id="fluc24hTitle">24h%</div>
                            <div class="TaskText" id="fluc7dTitle">7d%</div>
                            <div class="TaskText" id="capTitle">Market Cap</div>
                            <form class="TaskText" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <button type="submit" class="taskbarButtons" name="volume" id="volTitle">Volume 24h</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="Sidebar">
                    <div id="titleSidebar">
                        <p>Search Coins</p>
                    </div>
                    <div id="Navigation">
                        <form name="Search" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                            <select id="SearchBar" name="SearchBar">
                                <?php
                                    $j=count($market);
                                    for($i=0;$i<$j;$i++){
                                        $item=$market[$i];
                                        echo"<option> $item->name </option>";
                                    }
                                ?>
                            </select>
                            <button type="submit"> Submit </button>
                        </form>
                        <form name="ManualSearch" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                            <input id="searchBox" type="text" placeholder="Search.." name="ManualSearch">
                            <button type="submit"> Submit </button>
                        </form>
                        <form name="Reset" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                            <button id="homeButton" type="submit"> Home </button>
                        </form>
                    </div>
                </div>
                <div id="Content">
                    <?php
                        if(isset($_POST['name']) == FALSE)
                        {
                            setcookie("nameSort", "", time()-3600);
                        }
                        if(isset($_POST['price'])){
                            function price_Asc_Sort($a, $b){
                                $num = 0;
                                if($b->price - $a->price >= 0){
                                    $num = -1;
                                }
                                else if($b->price - $a->price <= 0){
                                    $num = 1;
                                }
                                return $num;
                            }
                            function price_Dsc_Sort($a, $b){
                                $num = 0;
                                if($b->price - $a->price <= 0){
                                    $num = -1;
                                }
                                else if($b->price - $a->price >= 0){
                                    $num = 1;
                                }
                                return $num;
                            }
                            if(isset($_COOKIE['priceSort']))
                            {
                                $priceSort = $_COOKIE['priceSort'];
                                if($priceSort == FALSE)
                                {
                                    $priceSort = TRUE;
                                }
                                else
                                {
                                    $priceSort = FALSE;
                                }
                                setcookie("priceSort", $priceSort);
                            }
                            else
                            {
                                $priceSort = TRUE;
                                setcookie("priceSort", $priceSort);
                            }
                            if($priceSort == TRUE)
                            {
                                usort($market, 'price_Asc_Sort');
                                $priceSort = 0;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                            else
                            {
                                usort($market, 'price_Dsc_Sort');
                                $priceSort = TRUE;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                        }
                        if(isset($_POST['volume']))
                        {
                            //sorts according to volume24h. Call usort($market, 'volume24hSort'); to invoke
                            function volume24hSort($a, $b){
                                return $a->volume24h - $b->volume24h;
                            }
                            function volume24hReverseSort($a, $b){
                                return $b->volume24h - $a->volume24h;
                            }
                            if(isset($_COOKIE['volSort']))
                            {
                                $volSort = $_COOKIE['volSort'];
                                if($volSort == FALSE)
                                {
                                    $volSort = TRUE;
                                }
                                else
                                {
                                    $volSort = FALSE;
                                }
                                setcookie("volSort", $volSort);
                            }
                            else
                            {
                                $volSort = TRUE;
                                setcookie("volSort", $volSort);
                            }
                            if($volSort == TRUE)
                            {
                                usort($market, 'volume24hSort');
                                $volSort = 0;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                            else
                            {
                                usort($market, 'volume24hReverseSort');
                                $volSort = TRUE;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                        }
                        if(isset($_POST['SearchBar']))
                        {
                            $j=count($market);
                            for($i=0;$i<$j;$i++)
                            {
                                $item=$market[$i];
                                if(strcmp($item->name, $_POST['SearchBar']) == 0)
                                {
                                    $Price = number_format((float)$item->price, 2);
                                    $MarketCap = number_format((float)$item->marketCap);
                                    $Volume = number_format((float)$item->volume24h);
                        
                                    echo '<div id="$coinName" class="coinDetails">';        
                                    echo '<img id="CoinImage"';
                                    echo "src=$item->imgPath  width=200 height=200>";
                                    echo '<p id="CoinName" name="SearchBar">';
                                    echo "$item->name<p>";
                                    echo '<p id="Price">';
                                    echo "$$Price<p>";
                                    if($item->fluctuation24h <= 0){
                                        echo '<p id="OneDayDown">';
                                        echo "&#x25BC;$item->fluctuation24h%<p>";
                                    }else{
                                        echo '<p id="OneDay">';
                                        echo "&#x25B2;$item->fluctuation24h%<p>";
                                    }
                                    if($item->fluctuation7d >= 0){
                                        echo '<p id="OneWeek">';
                                        echo "&#x25B2;$item->fluctuation7d%<p>";
                                    }
                                    else{
                                        echo '<p id="OneWeekDown">';
                                        echo "&#x25BC;$item->fluctuation7d%<p>";
                                    }
                                    echo '<p id="MarketCap">';
                                    echo "$$MarketCap<p>";
                                    echo '<p id="Volume24">';
                                    echo "$$Volume<p></div>";
                                    echo '<div id="description"><p>';
                                    echo "$item->description</p></div>";
                                    return;
                                }
                            }
                        }
                        elseif(isset($_POST['ManualSearch']))
                        {
                            $j=count($market);
                            $Search = $_POST['ManualSearch'];
                            $Search = htmlspecialchars($Search);
                            ucfirst(strtolower($Search));
                            $Search = "/" . preg_quote($Search, '/') . "/i";
                            for($i=0;$i<$j;$i++)
                            {
                                $item=$market[$i];
                                if(preg_match($Search, $item->name) == 1)
                                {
                                    $Price = number_format((float)$item->price, 2);
                                    $MarketCap = number_format((float)$item->marketCap);
                                    $Volume = number_format((float)$item->volume24h);

                                    echo '<div id="$coinName" class="coinDetails">';        
                                    echo '<img id="CoinImage"';
                                    echo "src=$item->imgPath  width=200 height=200>";
                                    echo '<p id="CoinName" name="SearchBar">';
                                    echo "$item->name<p>";
                                    echo '<p id="Price">';
                                    echo "$$Price<p>";
                                    if($item->fluctuation24h <= 0){
                                        echo '<p id="OneDayDown">';
                                        echo "&#x25BC;$item->fluctuation24h%<p>";
                                    }else{
                                        echo '<p id="OneDay">';
                                        echo "&#x25B2;$item->fluctuation24h%<p>";
                                    }
                                    if($item->fluctuation7d >= 0){
                                        echo '<p id="OneWeek">';
                                        echo "&#x25B2;$item->fluctuation7d%<p>";
                                    }
                                    else{
                                        echo '<p id="OneWeekDown">';
                                        echo "&#x25BC;$item->fluctuation7d%<p>";
                                    }
                                    echo '<p id="MarketCap">';
                                    echo "$$MarketCap<p>";
                                    echo '<p id="Volume24">';
                                    echo "$$Volume<p></div>";
                                    echo '<div id="description"><p>';
                                    echo "$item->description</p></div>";
                                    break;
                                }
                            }
                            return;
                        }
                        elseif(isset($_POST['name']))
                        {
                            if(isset($_COOKIE['nameSort']))
                            {
                                $nameSORT = $_COOKIE['nameSort'];
                                if($nameSORT == FALSE)
                                {
                                    $nameSORT = TRUE;
                                }
                                else
                                {
                                    $nameSORT = FALSE;
                                }
                                setcookie("nameSort", $nameSORT);
                            }
                            else
                            {
                                $nameSORT = TRUE;
                                setcookie("nameSort", $nameSORT);
                            }
                            if($nameSORT == TRUE)
                            {
                                function compare($a, $b)
                                {
                                    $retval = strnatcmp($a->name, $b->name);
                                    return $retval;
                                }
                                usort($market, __NAMESPACE__ . '\compare');
                                $nameSORT = 0;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                            else
                            {
                                function compare($a, $b)
                                {
                                    // if identical, sort by city
                                    $retval = strnatcmp($b->name, $a->name);
                                    return $retval;
                                }
                                usort($market, __NAMESPACE__ . '\compare');
                                $nameSORT = TRUE;
                                $j=count($market);
                                display($j, $market);
                                return;
                            }
                        }
                        else
                        {
                            display($j, $market);
                        }
                    ?>
                </div>
        </div>        
    </body>
</html>
