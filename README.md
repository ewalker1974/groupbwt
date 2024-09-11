# Transaction calculator
## Operation instruction
install package via composer install
run bin/console app:commission filename to calculate commission fees <br>
e.g bin/console app:commission ./example/input.txt will calculate commission from sample file<br>
In order to run tests use bin/phpunit command 

## Implementation notes
In order to get maximal flexibility and possibility of easily extension of application Symfony Framework DI is used <br>
All points of extension are implemented via interfaces thus you can change structure of Transaction and Fee in order 
to store extra data and extend Fee calculation workflow by adding new rules via Rule interface.<br>
Also it is possible to change data source by implementing new data reader viw Reader interface and data storing by 
implementing new writer via corresponding Writer interface.<br>
Also it is possible to replace CardService and CurrencyRate.<br>
Please, check the config/services.yaml to see how to configure application for existing reader and writer.<br>
I also a bit change receiving the currency rate data. Existing endpoint redirects to new one. It also requires API key.<br>
CurrencyRateImpl class

## Known issue
https://lookup.binlist.net/ has high rate limiter thus it is not possible to use my application more than once in hour.<br> 
It doesn't concern test 


