const asset = [
  {
    market: "stock",
    name: "Apple",
    percent_change_d: 23.69129264693116,
    price: 172.785,
    price_d_ago: 131.85,
    symbol: "AAPL",
    pairs: "NASDAQ:AAPL",
    small: "AAPL.us",
  },
  {
    market: "crypto",
    name: "Aave",
    percent_change_d: 0.6403628542710659,
    price: 55.5154,
    price_d_ago: 55.1599,
    symbol: "AAVEUSD",
    pairs: "BINANCE:AAVEUSDT",
    small: "aave",
  },
  {
    market: "stock",
    name: "Abbott Labs",
    percent_change_d: -5.541413745839041,
    price: 102.14,
    price_d_ago: 107.8,
    symbol: "ABT",
    pairs: "NYSE:ABT",
    small: "ABT.us",
  },
  {
    market: "crypto",
    name: "Cardano",
    percent_change_d: 5.387305581386859,
    price: 0.274215,
    price_d_ago: 0.2594422,
    symbol: "ADAUSD",
    pairs: "BINANCE:ADAUSDT",
    small: "cardano",
  },
  {
    market: "stock",
    name: "Adobe",
    percent_change_d: 14.595283620140217,
    price: 392.25,
    price_d_ago: 335,
    symbol: "ADBE",
    pairs: "NASDAQ:ADBE",
    small: "ADBE.us",
  },
  {
    market: "stock",
    name: "Automatic Data Processing Inc.",
    percent_change_d: 4.122021195620348,
    price: 218.79,
    price_d_ago: 204.75,
    symbol: "ADP",
    pairs: "NASDAQ:ADP",
    small: "ADP.us",
  }, // Changed This
  {
    market: "stock",
    name: "Bridger Aerospace Group",
    percent_change_d: 14.670255720053843,
    price: 6.15972,
    price_d_ago: 3.2536,
    symbol: "BAER",
    pairs: "NASDAQ:BAER",
    small: "BAER.ch",
  }, //Changed
  {
    market: "stock",
    name: "ISHARES ASIA",
    percent_change_d: -16.989567809239936,
    price: 53.68,
    price_d_ago: 62.8,
    symbol: "AIA",
    pairs: "NASDAQ:AIA",
    small: "AIA.hk",
  }, // Changed
  {
    market: "crypto",
    name: "Algorand",
    percent_change_d: -48.24918992369602,
    price: 0.114804,
    price_d_ago: 0.170196,
    symbol: "ALGOUSD",
    pairs: "BINANCE:ALGOUSDT",
    small: "algorand",
  },
  {
    market: "stock",
    name: "AMC Holdings",
    percent_change_d: 2.978723404255331,
    price: 4.7,
    price_d_ago: 4.56,
    symbol: "AMC",
    pairs: "NYSE:AMC",
    small: "AMC.us",
  },
  {
    market: "stock",
    name: "AMD",
    percent_change_d: 47.75123558484349,
    price: 121.4,
    price_d_ago: 63.43,
    symbol: "AMD",
    pairs: "NASDAQ:AMD",
    small: "AMD.us",
  },
  {
    market: "stock",
    name: "Tower Semiconductor",
    percent_change_d: -14.87725040916529,
    price: 183.3,
    price_d_ago: 210.57,
    symbol: "TSEM",
    pairs: "NASDAQ:TSEM",
    small: "TSM.us",
  }, // Changed
  {
    market: "stock",
    name: "Amazon",
    percent_change_d: 27.1904637605499,
    price: 114.93,
    price_d_ago: 83.68,
    symbol: "AMZN",
    pairs: "NASDAQ:AMZN",
    small: "AMZN.us",
  },
  {
    market: "crypto",
    name: "Avalanche",
    percent_change_d: 27.1904637605499,
    price: 114.93,
    price_d_ago: 83.68,
    symbol: "AVAXUSD",
    pairs: "COINBASE:AVAXUSD",
    small: "avalanche",
  }, // Added
  {
    market: "stock",
    name: "GALP ENERGIA-NOM",
    percent_change_d: -6.914893617021272,
    price: 3.76,
    price_d_ago: 4.02,
    symbol: "GALP",
    pairs: "EURONEXT:GALP",
    small: "GALP.pt",
  }, // Changed
  {
    market: "stock",
    name: "ASML",
    percent_change_d: 21.889596602972397,
    price: 706.5,
    price_d_ago: 551.85,
    symbol: "ASML",
    pairs: "NASDAQ:ASML",
    small: "ASML.nl",
  },
  {
    market: "stock",
    name: "Rivian Automotive INC",
    percent_change_d: -38.91270794031901,
    price: 14.5831,
    price_d_ago: 0.81,
    symbol: "RIVN",
    pairs: "NASDAQ:RIVN",
    small: "RIVN.us",
  }, // Changed
  {
    market: "crypto",
    name: "Cosmos",
    percent_change_d: -3.0217919787704433,
    price: 8.71238,
    price_d_ago: 8.97565,
    symbol: "ATOMUSD",
    pairs: "COINBASE:ATOMUSD",
    small: "cosmos",
  },
  {
    market: "index",
    name: "Spain 35 CFD",
    percent_change_d: 0,
    price: 7072.15,
    price_d_ago: 7072.15,
    symbol: "ESP35",
    pairs: "FOREXCOM:ESP35",
    small: "ESP35",
  }, //Changed
  {
    market: "forex",
    name: "AUDCAD",
    percent_change_d: -0.8978669428766116,
    price: 0.902695,
    price_d_ago: 0.9108,
    symbol: "AUDCAD",
    pairs: "OANDA:AUDCAD",
    small: "AUDCAD",
  },
  {
    market: "forex",
    name: "AUDCHF",
    percent_change_d: -1.574931524716317,
    price: 0.61336,
    price_d_ago: 0.62302,
    symbol: "AUDCHF",
    pairs: "OANDA:AUDCHF",
    small: "AUDCHF",
  },
  {
    market: "forex",
    name: "AUDJPY",
    percent_change_d: 6.644443159173244,
    price: 95.0945,
    price_d_ago: 88.776,
    symbol: "AUDJPY",
    pairs: "OANDA:AUDJPY",
    small: "AUDJPY",
  },
  {
    market: "forex",
    name: "AUDNZD",
    percent_change_d: 3.068999063525707,
    price: 1.0998700000000001,
    price_d_ago: 1.066115,
    symbol: "AUDNZD",
    pairs: "OANDA:AUDNZD",
    small: "AUDNZD",
  },
  {
    market: "forex",
    name: "AUDUSD",
    percent_change_d: 1.4572217111315575,
    price: 0.6793750000000001,
    price_d_ago: 0.669475,
    symbol: "AUDUSD",
    pairs: "OANDA:AUDUSD",
    small: "AUDUSD",
  },
  {
    market: "stock",
    name: "American Express",
    percent_change_d: 3.724320742213389,
    price: 150.9,
    price_d_ago: 145.28,
    symbol: "AXP",
    pairs: "NYSE:AXP",
    small: "AXP.us",
  },
  {
    market: "crypto",
    name: "Axie Infinity",
    percent_change_d: -39.41864601193402,
    price: 5.00418,
    price_d_ago: 6.97676,
    symbol: "AXSUSD",
    pairs: "COINBASE:AXSUSD",
    small: "axie-infinity",
  },
  {
    market: "stock",
    name: "Boeing",
    percent_change_d: 6.52271257276482,
    price: 200.99,
    price_d_ago: 187.88,
    symbol: "BA",
    pairs: "PYTH:BA",
    small: "BA.us",
  },
  {
    market: "stock",
    name: "Alibaba",
    percent_change_d: -12.02897629789668,
    price: 78.685,
    price_d_ago: 88.15,
    symbol: "BABA",
    pairs: "NYSE:BABA",
    small: "BABA.us",
  },
  {
    market: "stock",
    name: "Bank of America",
    percent_change_d: -14.971550497866277,
    price: 28.12,
    price_d_ago: 32.33,
    symbol: "BAC",
    pairs: "NYSE:BAC",
    small: "BAC.us",
  },
  {
    market: "stock",
    name: "Baidu INC",
    percent_change_d: 3.9380679905755693,
    price: 118.84,
    price_d_ago: 114.16,
    symbol: "BIDU",
    pairs: "NASDAQ:BIDU",
    small: "BIDU.us",
  },
  {
    market: "stock",
    name: "Bristol Myers",
    percent_change_d: -14.374225526641885,
    price: 64.56,
    price_d_ago: 73.84,
    symbol: "BMY",
    pairs: "NYSE:BMY",
    small: "BMY.us",
  },
  {
    market: "crypto",
    name: "Binance Coin",
    percent_change_d: 1.12766603431765,
    price: 248.24371,
    price_d_ago: 245.44435,
    symbol: "BNBUSD",
    pairs: " CRYPTO:BNBUSD",
    small: "binance-coin",
  },
  {
    market: "crypto",
    name: "Bitcoin SV",
    percent_change_d: -76.11779735090434,
    price: 25.2841,
    price_d_ago: 44.5298,
    symbol: "BSVUSD",
    pairs: "CRYPTO:BSVUSD",
    small: "bitcoin-sv",
  },
  {
    market: "crypto",
    name: "Bitcoin",
    percent_change_d: 35.174936793500784,
    price: 25962.52,
    price_d_ago: 16830.22,
    symbol: "BTCUSD",
    pairs: "COINBASE:BTCUSD",
    small: "bitcoin",
  },
  {
    market: "stock",
    name: "Citigroup",
    percent_change_d: 0.5203619909502353,
    price: 44.2,
    price_d_ago: 43.97,
    symbol: "C",
    pairs: "NYSE:C",
    small: "C.us",
  },
  {
    market: "forex",
    name: "CADCHF",
    percent_change_d: -0.6763221030011357,
    price: 0.67941,
    price_d_ago: 0.684005,
    symbol: "CADCHF",
    pairs: "OANDA:CADCHF",
    small: "CADCHF",
  },
  {
    market: "forex",
    name: "CADJPY",
    percent_change_d: 7.457054297418278,
    price: 105.3365,
    price_d_ago: 97.4815,
    symbol: "CADJPY",
    pairs: "OANDA:CADJPY",
    small: "CADJPY",
  },
  {
    market: "crypto",
    name: "PanCake Swap",
    percent_change_d: -188.29914529914532,
    price: 1.17,
    price_d_ago: 3.3731,
    symbol: "CAKEUSD",
    pairs: "CRYPTO:CAKEUSD",
    small: "pancakeswap",
  },
  {
    market: "stock",
    name: "Caterpiller",
    percent_change_d: -12.589910922688519,
    price: 209.93,
    price_d_ago: 236.36,
    symbol: "CAT",
    pairs: "NYSE:CAT",
    small: "CAT.us",
  },
  {
    market: "stock",
    name: "FIFTH THIRD BANCORP",
    percent_change_d: 16.129032258064512,
    price: 1.24,
    price_d_ago: 1.04,
    symbol: "FITB",
    pairs: "NASDAQ:FITB",
    small: "FITB.us",
  }, // Changed
  {
    market: "stock",
    name: "Fuelcell Energy Inc",
    percent_change_d: 13.90243902439028,
    price: 0.59,
    price_d_ago: 0.597,
    symbol: "FCEL",
    pairs: "NASDAQ:FCEL",
    small: "FCEL.us",
  }, // Changed
  {
    market: "stock",
    name: "Just Eat Takeaway",
    percent_change_d: -30.110908789935436,
    price: 30.205,
    price_d_ago: 39.3,
    symbol: "TKWY",
    pairs: "EURONEXT:TKWY",
    small: "TKWY.nl",
  }, // Changed
  {
    market: "stock",
    name: "Tractor Supply Company",
    percent_change_d: -4.236621196222461,
    price: 76.24,
    price_d_ago: 79.47,
    symbol: "TSCO",
    pairs: "NASDAQ:TSCO",
    small: "TSCO.uk",
  }, // Changed
  {
    market: "stock",
    name: "Xiaomi Corporation",
    percent_change_d: -58.27736736064472,
    price: 0.5956,
    price_d_ago: 0.9427,
    symbol: "XIAO",
    pairs: "SET:XIAOMI80",
    small: "XIAO.hk",
  }, // Changed
  {
    market: "stock",
    name: "Century Casinos INC.",
    percent_change_d: 10.463034024047078,
    price: 39.09,
    price_d_ago: 35,
    symbol: "CNTY",
    pairs: "NASDAQ:CNTY",
    small: "CASINOS",
  }, // Changed
  {
    market: "crypto",
    name: "Compound",
    percent_change_d: -19.5888187556357,
    price: 27.725,
    price_d_ago: 33.156,
    symbol: "COMPUSD",
    pairs: "BITSTAMP:COMPUSD",
    small: "compound",
  },
  {
    market: "stock",
    name: "UBER Technologies INC.",
    percent_change_d: 5.2989690721649465,
    price: 485,
    price_d_ago: 459.3,
    symbol: "UBER",
    pairs: "NYSE:UBER",
    small: "UBER.us",
  }, // Changed
  {
    market: "stock",
    name: "Occidental Petroleum Corporation",
    percent_change_d: 23.35329341317365,
    price: 1.67,
    price_d_ago: 1.28,
    symbol: "OXY",
    pairs: "NYSE:OXY",
    small: "OXY.us",
  }, // Changed
  {
    market: "stock",
    name: "Salesforce Inc",
    percent_change_d: 39.29577464788731,
    price: 213,
    price_d_ago: 129.3,
    symbol: "CRM",
    pairs: "NYSE:CRM",
    small: "CRM.us",
  },
  {
    market: "stock",
    name: "Chevron",
    percent_change_d: -11.452604335166605,
    price: 154.55,
    price_d_ago: 172.25,
    symbol: "CVX",
    pairs: "NYSE:CVX",
    small: "CVX.us",
  },
  {
    market: "crypto",
    name: "Dash",
    percent_change_d: -42.1010648905197,
    price: 30.0876,
    price_d_ago: 42.7548,
    symbol: "DASHUSD",
    pairs: "COINBASE:DASHUSD",
    small: "dash",
  },
  {
    market: "index",
    name: "Germany 30",
    percent_change_d: 0.08205826495145109,
    price: 13953.5,
    price_d_ago: 13942.05,
    symbol: "DE30EUR",
    pairs: "OANDA:DE30EUR",
    small: "GER30",
  },
  {
    market: "stock",
    name: "Disney",
    percent_change_d: 1.6035482770385654,
    price: 87.93,
    price_d_ago: 86.52,
    symbol: "DIS",
    pairs: "NYSE:DIS",
    small: "DIS.us",
  },
  {
    market: "crypto",
    name: "Dogecoin",
    percent_change_d: -47.43525591217452,
    price: 0.00889309,
    price_d_ago: 0.01311155,
    symbol: "DOGEUSD",
    pairs: "COINBASE:DOGEUSD",
    small: "dogecoin",
  },
  {
    market: "crypto",
    name: "Polkadot",
    percent_change_d: 3.0662356835114495,
    price: 4.64674,
    price_d_ago: 4.50426,
    symbol: "DOTUSD",
    pairs: "KRAKEN:DOTUSD",
    small: "polkadot",
  },
  {
    market: "stock",
    name: "Mastercard Incorporated",
    percent_change_d: 7.493659211436478,
    price: 43.37,
    price_d_ago: 40.12,
    symbol: "MA",
    pairs: "NYSE:MA",
    small: "MA.us",
  }, // Changed
  {
    market: "crypto",
    name: "Elrond",
    percent_change_d: -13.515811504627367,
    price: 30.579,
    price_d_ago: 34.712,
    symbol: "EGLDUSD",
    pairs: "BITFINEX:EGLDUSD",
    small: "elrond-egld",
  },
  {
    market: "crypto",
    name: "EOS",
    percent_change_d: -31.397123090825595,
    price: 0.67503,
    price_d_ago: 0.88697,
    symbol: "EOSUSD",
    pairs: "BITFINEX:EOSUSD",
    small: "eos",
  },
  {
    market: "crypto",
    name: "Ethereum",
    percent_change_d: 30.19249173357173,
    price: 1745.01,
    price_d_ago: 1218.148,
    symbol: "ETHUSD",
    pairs: "BITSTAMP:ETHUSD",
    small: "ethereum",
  },
  {
    market: "forex",
    name: "EURCAD",
    percent_change_d: -0.5056027188333406,
    price: 1.43591,
    price_d_ago: 1.4431699999999998,
    symbol: "EURCAD",
    pairs: "OANDA:EURCAD",
    small: "EURCAD",
  },
  {
    market: "forex",
    name: "EURCHF",
    percent_change_d: -1.1891459676675369,
    price: 0.97549,
    price_d_ago: 0.98709,
    symbol: "EURCHF",
    pairs: "OANDA:EURCHF",
    small: "EURCHF",
  },
  {
    market: "forex",
    name: "EURGBP",
    percent_change_d: -2.941348596041513,
    price: 0.8543700000000001,
    price_d_ago: 0.8795,
    symbol: "EURGBP",
    pairs: "OANDA:EURGBP",
    small: "EURGBP",
  },
  {
    market: "forex",
    name: "EURJPY",
    percent_change_d: 6.994218315609231,
    price: 151.2535,
    price_d_ago: 140.6745,
    symbol: "EURJPY",
    pairs: "OANDA:EURJPY",
    small: "EURJPY",
  },
  {
    market: "forex",
    name: "EURNZD",
    percent_change_d: 3.4049062214089765,
    price: 1.7488000000000001,
    price_d_ago: 1.689255,
    symbol: "EURNZD",
    pairs: "OANDA:EURNZD",
    small: "EURNZD",
  },
  {
    market: "forex",
    name: "EURUSD",
    percent_change_d: 1.837439153047413,
    price: 1.0805799999999999,
    price_d_ago: 1.0607250000000001,
    symbol: "EURUSD",
    pairs: "OANDA:EURUSD",
    small: "EURUSD",
  },
  {
    market: "stock",
    name: "Danaher Corporation",
    percent_change_d: 21.74610244988864,
    price: 224.5,
    price_d_ago: 175.68,
    symbol: "DHR",
    pairs: "NYSE:DHR",
    small: "DHR.us",
  }, // Changed
  {
    market: "crypto",
    name: "Filecoin",
    percent_change_d: 18.168308657603614,
    price: 3.6338,
    price_d_ago: 2.9736,
    symbol: "FILUSD",
    pairs: "COINBASE:FILUSD",
    small: "filecoin",
  },
  {
    market: "stock",
    name: "Alfa Financial Software",
    percent_change_d: 45.270270270270274,
    price: 14.8,
    price_d_ago: 8.1,
    symbol: "ALFA",
    pairs: "LSE:ALFA",
    small: "ALFA.se",
  }, // Changed
  {
    market: "crypto",
    name: "Fantom",
    percent_change_d: 21.63121188490383,
    price: 0.2626256,
    price_d_ago: 0.2058165,
    symbol: "FTMUSD",
    pairs: "BITFINEX:FTMUSD",
    small: "fantom",
  },
  {
    market: "crypto",
    name: "FTX Token",
    percent_change_d: -17.68032777207089,
    price: 0.84693,
    price_d_ago: 0.99667,
    symbol: "FTTUSD",
    pairs: "CRYPTO:FTTUSD",
    small: "ftx-token",
  },
  {
    market: "forex",
    name: "GBPAUD",
    percent_change_d: 3.2258064516129017,
    price: 1.861705,
    price_d_ago: 1.80165,
    symbol: "GBPAUD",
    pairs: "OANDA:GBPAUD",
    small: "GBPAUD",
  },
  {
    market: "forex",
    name: "GBPCAD",
    percent_change_d: 2.348257403765189,
    price: 1.680395,
    price_d_ago: 1.640935,
    symbol: "GBPCAD",
    pairs: "OANDA:GBPCAD",
    small: "GBPCAD",
  },
  {
    market: "forex",
    name: "GBPCHF",
    percent_change_d: 1.6993841922231154,
    price: 1.1415899999999999,
    price_d_ago: 1.12219,
    symbol: "GBPCHF",
    pairs: "OANDA:GBPCHF",
    small: "GBPCHF",
  },
  {
    market: "forex",
    name: "GBPJPY",
    percent_change_d: 9.628662801866856,
    price: 176.982,
    price_d_ago: 159.941,
    symbol: "GBPJPY",
    pairs: "OANDA:GBPJPY",
    small: "GBPJPY",
  },
  {
    market: "forex",
    name: "GBPNZD",
    percent_change_d: 6.132307128458875,
    price: 2.0463750000000003,
    price_d_ago: 1.920885,
    symbol: "GBPNZD",
    pairs: "OANDA:GBPNZD",
    small: "GBPNZD",
  },
  {
    market: "forex",
    name: "GBPUSD",
    percent_change_d: 4.620652569313742,
    price: 1.26454,
    price_d_ago: 1.20611,
    symbol: "GBPUSD",
    pairs: "OANDA:GBPUSD",
    small: "GBPUSD",
  },
  {
    market: "stock",
    name: "General Electric",
    percent_change_d: 19.54590325765054,
    price: 101.3,
    price_d_ago: 81.5,
    symbol: "GE",
    pairs: "NYSE:GE",
    small: "GE.us",
  },
  {
    market: "stock",
    name: "Gold",
    percent_change_d: 1.54590325765054,
    price: 1958.3,
    price_d_ago: 1952.5,
    symbol: "XAUUSD",
    pairs: "OANDA:XAUUSD",
    small: "XAUUSD",
  }, // Added
  {
    market: "stock",
    name: "AirBNB INC",
    percent_change_d: -53.99592884326048,
    price: 1.1299,
    price_d_ago: 1.74,
    symbol: "ABNB",
    pairs: "NASDAQ:ABNB",
    small: "ABNB.us",
  }, // Changed
  {
    market: "stock",
    name: "Microsoft Corporation",
    percent_change_d: -4.135802469135813,
    price: 32.4,
    price_d_ago: 33.74,
    symbol: "MSFT",
    pairs: "NASDAQ:MSFT",
    small: "MSFT.us",
  }, // Changed
  {
    market: "stock",
    name: "Google",
    percent_change_d: 28.991971454058874,
    price: 123.31,
    price_d_ago: 87.56,
    symbol: "GOOGL",
    pairs: "NASDAQ:GOOGL",
    small: "GOOG.us",
  },
  {
    market: "crypto",
    name: "The Graph",
    percent_change_d: 41.15209701869631,
    price: 0.09895,
    price_d_ago: 0.05823,
    symbol: "GRTUSD",
    pairs: "COINBASE:GRTUSD",
    small: "the-graph",
  },
  {
    market: "stock",
    name: "Goldman Sachs",
    percent_change_d: -6.861774532854846,
    price: 323.24,
    price_d_ago: 345.42,
    symbol: "GS",
    pairs: "NYSE:GS",
    small: "GS.us",
  },
  {
    market: "crypto",
    name: "Hedera Hashgraph",
    percent_change_d: 7.044423521355822,
    price: 0.046732,
    price_d_ago: 0.04344,
    symbol: "HBARUSD",
    pairs: "COINBASE:HBARUSD",
    small: "hedera-hashgraph",
  },
  {
    market: "stock",
    name: "Home Depot",
    percent_change_d: -9.312220982142852,
    price: 286.72,
    price_d_ago: 313.42,
    symbol: "HD",
    pairs: "NYSE:HD",
    small: "HD.us",
  },
  {
    market: "stock",
    name: "Honeywell",
    percent_change_d: -8.927545316825995,
    price: 191.43,
    price_d_ago: 208.52,
    symbol: "HON",
    pairs: "NASDAQ:HON",
    small: "HON.us",
  },
  {
    market: "stock",
    name: "IBM",
    percent_change_d: -11.011129528771008,
    price: 126.69,
    price_d_ago: 140.64,
    symbol: "IBM",
    pairs: "NYSE:IBM",
    small: "IBM.us",
  },
  {
    market: "crypto",
    name: "Internet Computer",
    percent_change_d: 3.623188405797093,
    price: 3.864,
    price_d_ago: 3.724,
    symbol: "ICPUSD",
    pairs: "COINBASE:ICPUSD",
    small: "internet-computer",
  },
  {
    market: "stock",
    name: "Tesla INC.",
    percent_change_d: -11.523015137472981,
    price: 32.37,
    price_d_ago: 36.1,
    symbol: "TSLA",
    pairs: "NASDAQ:TSLA",
    small: "TSLA.us",
  }, // Changed
  {
    market: "stock",
    name: "Intel",
    percent_change_d: 5.2631578947368345,
    price: 27.36,
    price_d_ago: 25.92,
    symbol: "INTC",
    pairs: "NASDAQ:INTC",
    small: "INTC.us",
  },
  {
    market: "stock",
    name: "Johnson & Johnson",
    percent_change_d: -14.731795802021235,
    price: 154.36,
    price_d_ago: 177.1,
    symbol: "JNJ",
    pairs: "NYSE:JNJ",
    small: "JNJ.us",
  },
  {
    market: "stock",
    name: "JP Morgan",
    percent_change_d: 3.4851953038470054,
    price: 135.43,
    price_d_ago: 130.71,
    symbol: "JPM",
    pairs: "NYSE:JPM",
    small: "JPM.us",
  },
  {
    market: "crypto",
    name: "Klaytn",
    percent_change_d: -4.7466072248082325,
    price: 0.15253,
    price_d_ago: 0.15977,
    symbol: "KLAYUSD",
    pairs: "CRYPTO:KLAYUSD",
    small: "klaytn",
  },
  {
    market: "crypto",
    name: "Chainlink",
    percent_change_d: -11.425201975156634,
    price: 5.39299,
    price_d_ago: 6.00915,
    symbol: "LINKUSD",
    pairs: "COINBASE:LINKUSD",
    small: "chainlink",
  },
  {
    market: "crypto",
    name: "Litecoin",
    percent_change_d: 15.331402085747388,
    price: 77.67,
    price_d_ago: 65.7621,
    symbol: "LTCUSD",
    pairs: "COINBASE:LTCUSD",
    small: "litecoin",
  },
  {
    market: "crypto",
    name: "Decentraland",
    percent_change_d: 8.859748533266181,
    price: 0.3430752,
    price_d_ago: 0.3126796,
    symbol: "MANAUSD",
    pairs: "COINBASE:MANAUSD",
    small: "decentraland",
  },
  {
    market: "crypto",
    name: "Polygon",
    percent_change_d: -22.741226380366125,
    price: 0.6527779,
    price_d_ago: 0.8012276,
    symbol: "MATICUSD",
    pairs: "COINBASE:MATICUSD",
    small: "polygon",
  },
  {
    market: "crypto",
    name: "Maker",
    percent_change_d: 15.2917247899095,
    price: 649.482,
    price_d_ago: 550.165,
    symbol: "MKRUSD",
    pairs: "BITSTAMP:MKRUSD",
    small: "maker",
  },
  {
    market: "index",
    name: "US Nas 100",
    percent_change_d: -0.15929179235309182,
    price: 10923.349999999999,
    price_d_ago: 10940.75,
    symbol: "NAS100USD",
    pairs: "OANDA:NAS100USD",
    small: "NAS100",
  },
  {
    market: "crypto",
    name: "NEAR Protocol",
    percent_change_d: -12.37721463519075,
    price: 1.200367,
    price_d_ago: 1.348939,
    symbol: "NEARUSD",
    pairs: "COINBASE:NEARUSD",
    small: "near-protocol",
  },
  {
    market: "crypto",
    name: "NEO",
    percent_change_d: 19.059966235398328,
    price: 7.92546,
    price_d_ago: 6.41487,
    symbol: "NEOUSD",
    pairs: "BITFINEX:NEOUSD",
    small: "neo",
  },
  {
    market: "forex",
    name: "NZDCAD",
    percent_change_d: -4.083186627761766,
    price: 0.820805,
    price_d_ago: 0.85432,
    symbol: "NZDCAD",
    pairs: "OANDA:NZDCAD",
    small: "NZDCAD",
  },
  {
    market: "forex",
    name: "NZDCHF",
    percent_change_d: -4.802855170063762,
    price: 0.557585,
    price_d_ago: 0.584365,
    symbol: "NZDCHF",
    pairs: "OANDA:NZDCHF",
    small: "NZDCHF",
  },
  {
    market: "forex",
    name: "NZDJPY",
    percent_change_d: 3.659855525930726,
    price: 86.4515,
    price_d_ago: 83.2875,
    symbol: "NZDJPY",
    pairs: "OANDA:NZDJPY",
    small: "NZDCAD",
  },
  {
    market: "forex",
    name: "NZDUSD",
    percent_change_d: -1.6487519020947503,
    price: 0.61774,
    price_d_ago: 0.6279250000000001,
    symbol: "NZDUSD",
    pairs: "OANDA:NZDUSD",
    small: "NZDUSD",
  },
  {
    market: "crypto",
    name: "THORChain",
    percent_change_d: -64.14270412787344,
    price: 0.84959,
    price_d_ago: 1.39454,
    symbol: "RUNEUSD",
    pairs: "KRAKEN:RUNEUSD",
    small: "thorchain",
  },
  {
    market: "crypto",
    name: "The Sandbox",
    percent_change_d: -14.298708710851118,
    price: 0.392476,
    price_d_ago: 0.448595,
    symbol: "SANDUSD",
    pairs: "BITSTAMP:SANDUSD",
    small: "the-sandbox",
  },
  {
    market: "crypto",
    name: "Shiba Inu",
    percent_change_d: -21.82361733931241,
    price: 0.0000068238,
    price_d_ago: 0.000008313,
    symbol: "SHIBUSD",
    pairs: "COINBASE:SHIBUSD",
    small: "shiba-inu",
  },
  {
    market: "crypto",
    name: "Solana",
    percent_change_d: 21.863190466785174,
    price: 15.189,
    price_d_ago: 11.8682,
    symbol: "SOLUSD",
    pairs: "COINBASE:SOLUSD",
    small: "solana",
  },
  {
    market: "index",
    name: "S&P 500 Index",
    percent_change_d: 0.06142907555777244,
    price: 3825.55,
    price_d_ago: 3823.2,
    symbol: "SPX500USD",
    pairs: "OANDA:SPX500USD",
    small: "SPX500",
  },
  {
    market: "crypto",
    name: "Theta",
    percent_change_d: -20.561305332477936,
    price: 0.646885,
    price_d_ago: 0.779893,
    symbol: "THETAUSD",
    pairs: "BITFINEX:THETAUSD",
    small: "theta",
  },
  {
    market: "crypto",
    name: "TRON",
    percent_change_d: 24.69155143649491,
    price: 0.0727674,
    price_d_ago: 0.0548,
    symbol: "TRXUSD",
    pairs: "BITFINEX:TRXUSD",
    small: "tron",
  },
  {
    market: "index",
    name: "UK100GBP",
    percent_change_d: -0.09791626147664795,
    price: 7455.35,
    price_d_ago: 7462.65,
    symbol: "UK100GBP",
    pairs: "OANDA:UK100GBP",
    small: "UK100",
  },
  {
    market: "crypto",
    name: "Uniswap",
    percent_change_d: -20.406749951182732,
    price: 4.40418,
    price_d_ago: 5.30293,
    symbol: "UNIUSD",
    pairs: "COINBASE:UNIUSD",
    small: "uniswap",
  },
  {
    market: "index",
    name: "US ROSS 2000",
    percent_change_d: -0.21418339581776935,
    price: 1750.836,
    price_d_ago: 1754.586,
    symbol: "US2000USD",
    pairs: "OANDA:US2000USD",
    small: "US2000",
  },
  {
    market: "index",
    name: "US Wall St 30",
    percent_change_d: -0.02574002574002574,
    price: 33022.5,
    price_d_ago: 33031,
    symbol: "US30USD",
    pairs: "OANDA:US30USD",
    small: "US30",
  },
  {
    market: "forex",
    name: "USDCAD",
    percent_change_d: -2.391354247805251,
    price: 1.328745,
    price_d_ago: 1.36052,
    symbol: "USDCAD",
    pairs: "OANDA:USDCAD",
    small: "USDCAD",
  },
  {
    market: "forex",
    name: "USDCHF",
    percent_change_d: -3.0929776556735917,
    price: 0.90269,
    price_d_ago: 0.9306099999999999,
    symbol: "USDCHF",
    pairs: "OANDA:USDCHF",
    small: "USDCHF",
  },
  {
    market: "forex",
    name: "USDJPY",
    percent_change_d: 5.236423128994113,
    price: 139.9715,
    price_d_ago: 132.642,
    symbol: "USDJPY",
    pairs: "OANDA:USDJPY",
    small: "USDJPY",
  },
  {
    market: "forex",
    name: "USDMXN",
    percent_change_d: -13.468272798111238,
    price: 17.1966,
    price_d_ago: 19.512684999999998,
    symbol: "USDMXN",
    pairs: "OANDA:USDMXN",
    small: "USDMXN",
  },
  {
    market: "forex",
    name: "USDSGD",
    percent_change_d: -0.6768921110013587,
    price: 1.341425,
    price_d_ago: 1.350505,
    symbol: "USDSGD",
    pairs: "OANDA:USDSGD",
    small: "USDCAD",
  },
  {
    market: "forex",
    name: "USDTHB",
    percent_change_d: -0.27255422242732924,
    price: 34.672,
    price_d_ago: 34.7665,
    symbol: "USDTHB",
    pairs: "OANDA:USDTHB",
    small: "USDCAD",
  },
  {
    market: "forex",
    name: "USDTRY",
    percent_change_d: 20.680494201761334,
    price: 23.557585,
    price_d_ago: 18.685760000000002,
    symbol: "USDTRY",
    pairs: "OANDA:USDTRY",
    small: "USDTRY",
  },
  {
    market: "forex",
    name: "USDZAR",
    percent_change_d: 7.191564324705567,
    price: 18.460169999999998,
    price_d_ago: 17.132595,
    symbol: "USDZAR",
    pairs: "OANDA:USDZAR",
    small: "USDZAR",
  },
  {
    market: "crypto",
    name: "Wrapped Bitcoin",
    percent_change_d: 35.170945773979845,
    price: 25932.2,
    price_d_ago: 16811.6,
    symbol: "WBTCUSD",
    pairs: "COINBASE:WBTCUSD",
    small: "wrapped-bitcoin",
  },
  {
    market: "crypto",
    name: "Stellar",
    percent_change_d: 7.481558251539355,
    price: 0.082015,
    price_d_ago: 0.075879,
    symbol: "XLMUSD",
    pairs: "COINBASE:XLMUSD",
    small: "stellar",
  },
  {
    market: "crypto",
    name: "Monero",
    percent_change_d: -4.228759158985299,
    price: 136.7919,
    price_d_ago: 142.5765,
    symbol: "XMRUSD",
    pairs: "KRAKEN:XMRUSD",
    small: "monero",
  },
  {
    market: "crypto",
    name: "Tezos",
    percent_change_d: -2.697699122727493,
    price: 0.783223,
    price_d_ago: 0.804352,
    symbol: "XTZUSD",
    pairs: "COINBASE:XTZUSD",
    small: "tezos",
  },
  {
    market: "crypto",
    name: "eCash",
    percent_change_d: -55.74519059705387,
    price: 25.2942,
    price_d_ago: 39.3945,
    symbol: "XECUSD",
    pairs: "BITFINEX:XECUSD",
    small: "ecash",
  },
  {
    market: "crypto",
    name: "Bitcoin Cash",
    percent_change_d: 2.5885162922323232,
    price: 496.945,
    price_d_ago: 495.945,
    symbol: "BCHUSD",
    pairs: "COINBASE:BCHUSD",
    small: "bitcoin-cash",
  },
  {
    market: "crypto",
    name: "Render Token",
    percent_change_d: -0.788451533698841,
    price: 10.1190169138060407,
    price_d_ago: 10.0190169138060407,
    symbol: "RNDRUSD",
    pairs: "KRAKEN:RNDRUSD",
    small: "render-token",
  },
  {
    market: "crypto",
    name: "Crypto.com Coin",
    percent_change_d: -0.2314203882669974,
    price: 0.1213864041949327,
    price_d_ago: 0.1213764041449327,
    symbol: "CROUSD",
    pairs: "COINBASE:CROUSD",
    small: "crypto-com-coin",
  },
  {
    market: "crypto",
    name: "VeChain",
    percent_change_d: 0.8362966738130290,
    price: 0.0351319703627315,
    price_d_ago: 0.1213764041449327,
    symbol: "VETUSD",
    pairs: "COINBASE:VETUSD",
    small: "vechain",
  },
  {
    market: "crypto",
    name: "Fetch.ai",
    percent_change_d: -1.9823009922693871,
    price: 2.3136324795850028,
    price_d_ago: 0.1213764041449327,
    symbol: "FETUSD",
    pairs: "COINBASE:FETUSD",
    small: "fetch",
  },
  {
    market: "crypto",
    name: "Gala",
    percent_change_d: 0.7883292368739207,
    price: 0.0430355344701285,
    price_d_ago: 0.0428355344701285,
    symbol: "GALAUSD",
    pairs: "BINANCE:GALAUSD",
    small: "gala",
  },
  {
    market: "crypto",
    name: "SingularityNET",
    percent_change_d: -2.0468101940797612,
    price: 0.9619152659968714,
    price_d_ago: 0.9659152659748714,
    symbol: "AGIXUSD",
    pairs: "COINBASE:AGIXUSD",
    small: "singularitynet",
  },
];

const favs = [
  {
    market: "stock",
    name: "Apple",
    percent_change_d: 23.69129264693116,
    price: 172.785,
    price_d_ago: 131.85,
    symbol: "AAPL",
    pairs: "NASDAQ:AAPL",
    small: "AAPL.us",
  },
  {
    market: "crypto",
    name: "Aave",
    percent_change_d: 0.6403628542710659,
    price: 55.5154,
    price_d_ago: 55.1599,
    symbol: "AAVEUSD",
    pairs: "BINANCE:AAVEUSDT",
    small: "aave",
  },
  {
    market: "stock",
    name: "Abbott Labs",
    percent_change_d: -5.541413745839041,
    price: 102.14,
    price_d_ago: 107.8,
    symbol: "ABT",
    pairs: "NYSE:ABT",
    small: "ABT.us",
  },
  {
    market: "index",
    name: "Spain 35 CFD",
    percent_change_d: 0,
    price: 7072.15,
    price_d_ago: 7072.15,
    symbol: "ESP35",
    pairs: "FOREXCOM:ESP35",
    small: "ESP35",
  }, //Changed
  {
    market: "forex",
    name: "AUDCAD",
    percent_change_d: -0.8978669428766116,
    price: 0.902695,
    price_d_ago: 0.9108,
    symbol: "AUDCAD",
    pairs: "OANDA:AUDCAD",
    small: "AUDCAD",
  },
  {
    market: "forex",
    name: "AUDCHF",
    percent_change_d: -1.574931524716317,
    price: 0.61336,
    price_d_ago: 0.62302,
    symbol: "AUDCHF",
    pairs: "OANDA:AUDCHF",
    small: "AUDCHF",
  },
  {
    market: "crypto",
    name: "Cardano",
    percent_change_d: 5.387305581386859,
    price: 0.274215,
    price_d_ago: 0.2594422,
    symbol: "ADAUSD",
    pairs: "BINANCE:ADAUSDT",
    small: "cardano",
  },
  {
    market: "stock",
    name: "Adobe",
    percent_change_d: 14.595283620140217,
    price: 392.25,
    price_d_ago: 335,
    symbol: "ADBE",
    pairs: "NASDAQ:ADBE",
    small: "ADBE.us",
  },
  {
    market: "stock",
    name: "Automatic Data Processing Inc.",
    percent_change_d: 4.122021195620348,
    price: 218.79,
    price_d_ago: 204.75,
    symbol: "ADP",
    pairs: "NASDAQ:ADP",
    small: "ADP.us",
  },
  {
    market: "crypto",
    name: "Bitcoin Cash",
    percent_change_d: 2.5885162922323232,
    price: 496.945,
    price_d_ago: 495.945,
    symbol: "BCHUSD",
    pairs: "COINBASE:BCHUSD",
    small: "bitcoin-cash",
  },
  {
    market: "crypto",
    name: "Render Token",
    percent_change_d: -0.788451533698841,
    price: 10.1190169138060407,
    price_d_ago: 10.0190169138060407,
    symbol: "RNDRUSD",
    pairs: "KRAKEN:RNDRUSD",
    small: "render-token",
  },
  {
    market: "crypto",
    name: "Crypto.com Coin",
    percent_change_d: -0.2314203882669974,
    price: 0.1213864041949327,
    price_d_ago: 0.1213764041449327,
    symbol: "CROUSD",
    pairs: "COINBASE:CROUSD",
    small: "crypto-com-coin",
  },
  {
    market: "crypto",
    name: "VeChain",
    percent_change_d: 0.8362966738130290,
    price: 0.0351319703627315,
    price_d_ago: 0.1213764041449327,
    symbol: "VETUSD",
    pairs: "COINBASE:VETUSD",
    small: "vechain",
  },
  {
    market: "crypto",
    name: "Fetch.ai",
    percent_change_d: -1.9823009922693871,
    price: 2.3136324795850028,
    price_d_ago: 0.1213764041449327,
    symbol: "FETUSD",
    pairs: "COINBASE:FETUSD",
    small: "fetch",
  },
  {
    market: "crypto",
    name: "Gala",
    percent_change_d: 0.7883292368739207,
    price: 0.0430355344701285,
    price_d_ago: 0.0428355344701285,
    symbol: "GALAUSD",
    pairs: "BINANCE:GALAUSD",
    small: "gala",
  },
  {
    market: "crypto",
    name: "SingularityNET",
    percent_change_d: -2.0468101940797612,
    price: 0.9619152659968714,
    price_d_ago: 0.9659152659748714,
    symbol: "AGIXUSD",
    pairs: "BINANCE:AGIXUSD",
    small: "singularitynet",
  },
];

let assetwithprices = [];

let newassets = [];

const cryptos = [];

const stocks = [];

const indices = [];

const forex = [];

const gainers = [];

const losers = [];

var s = [];

var cr = [];

var f = [];

var ind = [];

const separateAssets = (arr = []) => {
  for (let i = 0; i < arr.length; i++) {
    if (arr[i].market === "stock") stocks.push(arr[i]);
    if (arr[i].market === "index") indices.push(arr[i]);
    if (arr[i].market === "crypto") cryptos.push(arr[i]);
    if (arr[i].market === "forex") forex.push(arr[i]);
  }
};

// Loser Data to show
let dataLosers = [];
//Gainer Data to show
let dataGainers = [];
//Favorite Data to show
let dataFavs = [];

let c = [];
let o = [];

function sgainers(arr = []) {
  let filteg = arr.reduce(
    (a, o) => (o.percent_change_d > 2 && a.push(o), a),
    []
  );
  filteg.sort((a, b) => (a.percent_change_d > b.percent_change_d ? -1 : 1));
  rre = filteg.reduce(() => filteg.slice(0, 10));
  if (rre.length > 0) {
    createGainerDivs(rre);
  }
}

function slosers(arr = []) {
  let filtel = arr.reduce(
    (a, o) => (o.percent_change_d < 0 && a.push(o), a),
    []
  ); // Check the percentage change
  filtel.sort((a, b) => (a.percent_change_d > b.percent_change_d ? 1 : -1)); // sort based on the highest pecentage.
  rrs = filtel.reduce(() => filtel.slice(0, 10));
  if (rrs.length > 0) {
    createLosersDivs(rrs);
  }
}

// const createFavDivs = (arr) => {
//   for (var i = 0; i < arr.length; i++) {
//     if (arr[i].price > 1) {
//       prices = parseFloat(arr[i].price)
//         .toFixed(2)
//         .replace(/\d(?=(\d{3})+\.)/g, "$&,");
//     } else {
//       prices = parseFloat(arr[i].price).toFixed(5);
//     }
//     var cardf = `<div class="card border border-2 mb-3" id="cardf${i}" style="cursor: pointer;" dataIndex="${i}">
//           <div class="card-body">
//           <div class="row">

//           <div class="col-md-2" dataIndex="${i}" style="width: 16.66667% !important;">
//           <img class="img-fluid" width="35" height="35" src ="../../assets/images/svgs/${arr[
//             i
//           ].symbol.toLowerCase()}-image.svg" />
//           </div>

//           <div class="col-md-4" dataIndex="${i}" style="width: 33.33333% !important;">
//           <p class="text-start small mb-0">${arr[i].symbol}</p>
//           <p class="text-start small">${arr[i].name}</p>
//           </div>

//           <div class="col-md-3" dataIndex="${i}" style="width: 28% !important;">
//           <p class="text-start small">$${prices}</p>
//           </div>

//           <div class="col-md-3" dataIndex="${i}" style="width: 22% !important;">
//           <p class="text-start badge bg-danger small">${parseFloat(
//             arr[i].percent_change_d
//           ).toFixed(2)}%</p>
//           </div>
//          </div>
//          </div>`;

//     dataFavs.push(cardf);
//   }
//   $("#favorites").append(dataFavs);

//   if (dataFavs.length > 0) {
//     for (var i = 0; i < arr.length; i++) {
//       $("#cardf" + i).click(function () {
//         var index = this.getAttribute("dataIndex");
//         redir("chart", {
//           market: arr[index].market,
//           symbol: arr[index].symbol,
//         });
//       });
//     }
//   }
// };

// createFavDivs(favs);

const createLosersDivs = (arr) => {
  for (var i = 0; i < arr.length; i++) {
    if (arr[i].price > 1) {
      prices = parseFloat(arr[i].price)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    } else if (arr[i].symbol == "SHIBUSD") {
      prices = parseFloat(arr[i].price).toFixed(7);
    } else {
      prices = parseFloat(arr[i].price).toFixed(5);
    }
    var cards = `<div class="card border border-2 mb-3" id="cards${i}" style="cursor: pointer;" dataIndex="${i}">
      <div class="card-body">
      <div class="row">

      <div class="col-md-2" dataIndex="${i}" style="width: 16.66667% !important;">
      <img class="img-fluid" width="35" height="35" src ="../../assets/images/svgs/${arr[
        i
      ].symbol.toLowerCase()}-image.svg" />
      </div>

      <div class="col-md-4" dataIndex="${i}" style="width: 33.33333% !important;">
      <p class="text-start small mb-0">${arr[i].symbol}</p>
      <p class="text-start small">${arr[i].name}</p>
      </div>
      
      <div class="col-md-3" dataIndex="${i}" style="width: 28% !important;">
      <p class="text-start small">$${prices}</p>
      </div>

      <div class="col-md-3" dataIndex="${i}" style="width: 22% !important;">
      <p class="text-start badge bg-danger small">${parseFloat(
        arr[i].percent_change_d
      ).toFixed(2)}%</p>
      </div>
     </div>
     </div>`;

    dataLosers.push(cards);
  }

  $("#losers").append(dataLosers);

  if (dataLosers.length > 0) {
    for (var i = 0; i < arr.length; i++) {
      $("#cards" + i).click(function () {
        var index = this.getAttribute("dataIndex");
        redir("chart", {
          market: arr[index].market,
          symbol: arr[index].symbol,
        });
      });
    }
  }
};

const createGainerDivs = (arr) => {
  for (var i = 0; i < arr.length; i++) {
    if (arr[i].price > 1) {
      prices = parseFloat(arr[i].price)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    } else if (arr[i].symbol == "SHIBUSD") {
      prices = parseFloat(arr[i].price).toFixed(7);
    } else {
      prices = parseFloat(arr[i].price).toFixed(5);
    }
    var card = `<div class="card border border-2 mb-3" id="card${i}" style="cursor: pointer;" dataIndex="${i}">
      <div class="card-body">
      <div class="row">

      <div class="col-md-2" dataIndex="${i}" style="width: 16.66667% !important;">
      <img class="img-fluid" width="35" height="35" src ="../../assets/images/svgs/${arr[
        i
      ].symbol.toLowerCase()}-image.svg" />
      </div>

      <div class="col-md-4" dataIndex="${i}" style="width: 33.33333% !important;">
      <p class="text-start small mb-0">${arr[i].symbol}</p>
      <p class="text-start small">${arr[i].name}</p>
      </div>
      
      <div class="col-md-3" dataIndex="${i}" style="width: 28% !important;">
      <p class="text-start small">$${prices}</p>
      </div>

      <div class="col-md-3" dataIndex="${i}" style="width: 22% !important;">
      <p class="text-start badge bg-success small">${parseFloat(
        arr[i].percent_change_d
      ).toFixed(2)}%</p>
      </div>
     </div>
     </div>`;
    dataGainers.push(card);
  }

  $("#gainers").append(dataGainers);

  if (dataGainers.length > 0) {
    for (var i = 0; i < arr.length; i++) {
      $("#card" + i).click(function () {
        var index = this.getAttribute("dataIndex");
        redir("chart", {
          market: arr[index].market,
          symbol: arr[index].symbol,
        });
      });
    }
  }
};

const getGainers = () => {
  let cryp = [];
  let list = [];
  let oth = [];

  for (var i = 0; i < asset.length; i++) {
    if (asset[i].market == "crypto") {
      cryp.push(asset[i]);
      list.push(asset[i].small);
    } else {
      oth.push(asset[i]);
    }
  }

  $.ajax({
    url: "https://api.coincap.io/v2/assets?ids=" + list.join(","),
    method: "GET",
    async: true,
    success: function (json) {
      if (json.data.length > 0) {
        let index;
        for (var j = 0; j < json.data.length; j++) {
          index = json.data.findIndex((object) => {
            return object.id === cryp[j].small;
          });
          cryp[j].price = parseFloat(json.data[index].priceUsd).toFixed(4);
          cryp[j].percent_change_d = parseFloat(
            json.data[index].changePercent24Hr
          );
          c.push(cryp[j]);
        }
      }
      $.ajax({
        url: "https://ratesjson.fxcm.com/DataDisplayerMKTs",
        method: "GET",
        async: true,
        crossDomain: true,
        dataType: "jsonp",
        success: function (json) {
          if (json.Rates.length > 0) {
            let index;
            for (var j = 0; j < oth.length; j++) {
              index = json.Rates.findIndex((object) => {
                return object.Symbol === oth[j].small;
              });
              oth[j].price = parseFloat(json.Rates[index].Ask).toFixed(4);
              oth[j].percent_change_d = parseFloat(
                json.Rates[index].PercentChange * 100
              );
              o.push(oth[j]);
            }
          }

          assetwithprices = o.concat(c);

          shuffle(assetwithprices);

          if (assetwithprices.length > 0) {
            sgainers(assetwithprices);
            slosers(assetwithprices);
            $("#loadGainers").remove();
            $("#loadLosers").remove();
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
};

const createMarketDiv = (arr, div) => {
  var db = [];
  $("#" + div).html("");
  for (var i = 0; i < arr.length; i++) {
    if (arr[i].price > 1) {
      prices = parseFloat(arr[i].price)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    } else if (arr[i].symbol == "SHIBUSD") {
      prices = parseFloat(arr[i].price).toFixed(7);
    } else {
      prices = parseFloat(arr[i].price).toFixed(5);
    }
    var badge = "";

    if (arr[i].percent_change_d > 0) {
      badge = "bg-success";
    } else if (arr[i].percent_change_d < 0) {
      badge = "bg-danger";
    } else {
      badge = "bg-primary";
    }
    var cardss = `<div class="card border border-2 mb-3" id="cardss${i}${arr[
      i
    ].symbol.toLowerCase()}" style="cursor: pointer;" dataIndex="${i}">
         <div class="card-body px-2">
         <div class="row">
   
         <div class="col-md-2" dataIndex="${i}" style="width: 15.66667% !important;">
         <img class="img-fluid" width="35" height="35" src ="../../assets/images/svgs/${arr[
           i
         ].symbol.toLowerCase()}-image.svg" />
         </div>
   
         <div class="col-md-4" dataIndex="${i}" style="width: 34.33333% !important;">
         <p class="text-start small mb-0">${arr[i].name}</p>
         <p class="text-start small">${arr[i].symbol}</p>
         </div>
         
         <div class="col-md-3" dataIndex="${i}" style="width: 28% !important;">
         <p class="text-start small">$${prices}</p>
         </div>
   
         <div class="col-md-3" dataIndex="${i}" style="width: 22% !important;">
         <p class="text-start badge ${badge} small">${parseFloat(
      arr[i].percent_change_d
    ).toFixed(2)}%</p>
         </div>
        </div>
        </div>`;
    db.push(cardss);
  }

  $("#" + div).html(db);

  if (db.length > 0) {
    for (var i = 0; i < arr.length; i++) {
      $("#cardss" + i + arr[i].symbol.toLowerCase()).click(function () {
        var index = this.getAttribute("dataIndex");
        redir("chart", {
          market: arr[index].market,
          symbol: arr[index].symbol,
        });
      });
    }
  }
};

const livecPrice = () => {
  var list = [];
  for (var i = 0; i < c.length; i++) {
    list.push(c[i].small);
  }
  $.ajax({
    url: "https://api.coincap.io/v2/assets?ids=" + list.join(","),
    method: "GET",
    success: function (json) {
      let index;
      for (var j = 0; j < json.data.length; j++) {
        index = json.data.findIndex((object) => {
          return object.id === c[j].small;
        });
        c[j].price = parseFloat(json.data[index].priceUsd).toFixed(4);
        c[j].percent_change_d = parseFloat(json.data[index].changePercent24Hr);

        var prices = "";

        if (json.data[index].priceUsd > 1) {
          prices = parseFloat(json.data[index].priceUsd)
            .toFixed(2)
            .replace(/\d(?=(\d{3})+\.)/g, "$&,");
        } else {
          prices = parseFloat(json.data[index].priceUsd).toFixed(6);
        }

        var badge = "";

        if (json.data[index].changePercent24Hr > 0) {
          badge = "badge-success";
        } else if (json.data[index].changePercent24Hr < 0) {
          badge = "badge-danger";
        } else {
          badge = "badge-primary";
        }
        $("#p" + c[j].symbol.toLowerCase()).html(
          "<span class='small p'>" + prices + "</span>"
        );
        $("#per" + c[j].symbol.toLowerCase()).html(
          "<span class='badge p " +
            badge +
            "'>" +
            parseFloat(json.data[index].changePercent24Hr).toFixed(2) +
            "%</span>"
        );
      }
      setTimeout(function () {
        livecPrice();
      }, 10000);
    },
    error: function () {
      setTimeout(function () {
        livecPrice();
      }, 10000);
    },
  });
};

const livePrice = (arr) => {
  var newArr = arr;
  var list = [];
  for (var i = 0; i < arr.length; i++) {
    list.push(arr[i].small);
  }
  $.ajax({
    url: "https://ratesjson.fxcm.com/DataDisplayerMKTs",
    method: "GET",
    crossDomain: true,
    dataType: "jsonp",
    success: function (json) {
      if (json.Rates.length > 0) {
        let index;
        for (var j = 0; j < arr.length; j++) {
          index = json.Rates.findIndex((object) => {
            return object.Symbol === arr[j].small;
          });
          arr[j].price = parseFloat(json.Rates[index].Ask).toFixed(4);
          arr[j].percent_change_d = parseFloat(
            json.Rates[index].PercentChange * 100
          );

          var badge = "";

          if (json.Rates[index].PercentChange * 100 > 0) {
            badge = "badge-success";
          } else if (json.Rates[index].PercentChange * 100 < 0) {
            badge = "badge-danger";
          } else {
            badge = "badge-primary";
          }

          var prices = "";

          if (json.Rates[index].Ask > 1) {
            prices = parseFloat(json.Rates[index].Ask)
              .toFixed(2)
              .replace(/\d(?=(\d{3})+\.)/g, "$&,");
          } else {
            prices = parseFloat(json.Rates[index].Ask).toFixed(6);
          }
          $("#p" + arr[j].symbol.toLowerCase()).html(
            "<span class='small p'>" + prices + "</span>"
          );
          $("#per" + arr[j].symbol.toLowerCase()).html(
            "<span class='badge p " +
              badge +
              "'>" +
              parseFloat(json.Rates[index].PercentChange * 100).toFixed(2) +
              "%</span>"
          );
        }
      }
      setTimeout(function () {
        livePrice(newArr);
      }, 10000);
    },
    error: function () {
      setTimeout(function () {
        livePrice(newArr);
      }, 10000);
    },
  });
};

const getSeperate = () => {
  let cryp = [];
  let list = [];
  let oth = [];
//   let mee = [];
//   let you = [];

  for (var i = 0; i < asset.length; i++) {
    if (asset[i].market == "crypto") {
      cryp.push(asset[i]);
      list.push(asset[i].small);
    } else {
      oth.push(asset[i]);
    }
  }

  $.ajax({
    url: "https://api.coincap.io/v2/assets?ids=" + list.join(","),
    method: "GET",
    async: true,
    success: function (json) {
      if (json.data.length > 0) {
        let index;
        for (var j = 0; j < json.data.length; j++) {
          index = json.data.findIndex((object) => {
            return object.id === cryp[j].small;
          });
          cryp[j].price = parseFloat(json.data[index].priceUsd).toFixed(4);
          cryp[j].percent_change_d = parseFloat(
            json.data[index].changePercent24Hr
          );
          c.push(cryp[j]);
        }
      }
      $.ajax({
        url: "https://ratesjson.fxcm.com/DataDisplayerMKTs",
        method: "GET",
        crossDomain: true,
        dataType: "jsonp",
        success: function (json) {
          newassets = [];
          if (json.Rates.length > 0) {
            let index;
            for (var j = 0; j < oth.length; j++) {
              index = json.Rates.findIndex((object) => {
                return object.Symbol === oth[j].small;
              });
              oth[j].price = parseFloat(json.Rates[index].Ask).toFixed(4);
              oth[j].percent_change_d = parseFloat(
                json.Rates[index].PercentChange * 100
              );
              o.push(oth[j]);
            // mee.push(json.Rates[index]);
            // you.push(oth[j].small);
            // console.log(json.Rates[index].Symbol, json.Rates[index].Ask)
            }
            // console.log(mee, you);
          }

          newassets = o.concat(c);

          if (newassets.length > 0) {
            for (var i = 0; i < newassets.length; i++) {
              if (newassets[i].market === "stock") s.push(newassets[i]);
              if (newassets[i].market === "index") ind.push(newassets[i]);
              if (newassets[i].market === "crypto") cr.push(newassets[i]);
              if (newassets[i].market === "forex") f.push(newassets[i]);
            }
            if (s.length > 0) {
              createMarketDiv(s, "stocks");
              livePrice(s);
            }
            if (cr.length > 0) {
              createMarketDiv(cr, "crypto");
              livecPrice();
            }
            if (f.length > 0) {
              createMarketDiv(f, "forex");
              livePrice(f);
            }
            if (ind.length > 0) {
              createMarketDiv(ind, "index");
              livePrice(ind);
            }

            $("#stocksDiv").remove();
            $("#cryptoDiv").remove();
            $("#forexDiv").remove();
            $("#indexDiv").remove();
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
};

function shuffle(array) {
  let currentIndex = array.length,
    randomIndex;

  // While there remain elements to shuffle.
  while (currentIndex != 0) {
    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex],
      array[currentIndex],
    ];
  }

  return array;
}
