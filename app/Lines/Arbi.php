<?php

namespace App\Lines;

use Illuminate\Support\Facades\Redis;
use Line;
use App\Ticker;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

class Arbi
{
    public function Price()
    {

		$tickers = file_get_contents('https://bx.in.th/api/');
		$tickers = json_decode($tickers);
		$prices  = array();


		foreach ($tickers as $key => $ticker)
		{
			switch ($ticker->pairing_id)
			{
				case 1:
					$prices['Bitcoin']['price'] = number_format($ticker->last_price) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['Bitcoin']['color'] = '#7bb200';
					} else
					{
						$prices['Bitcoin']['color'] = '#ed027b';
					}
					$prices['Bitcoin']['change'] = number_format($ticker->change, 2) . '%';
					break;

				case 21:
					$prices['Ethereum']['price']  = number_format($ticker->last_price) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['Ethereum']['color'] = '#7bb200';
					} else
					{
						$prices['Ethereum']['color'] = '#ed027b';
					}
					$prices['Ethereum']['change'] = number_format($ticker->change, 2) . '%';
					break;

				case 25:
					$prices['Ripple']['price']  = number_format($ticker->last_price, 2) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['Ripple']['color'] = '#7bb200';
					} else
					{
						$prices['Ripple']['color'] = '#ed027b';
					}
					$prices['Ripple']['change'] = number_format($ticker->change, 2) . '%';
					break;

				case 27:
					$prices['Bitcoin Cash']['price']  = number_format($ticker->last_price) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['Bitcoin Cash']['color'] = '#7bb200';
					} else
					{
						$prices['Bitcoin Cash']['color'] = '#ed027b';
					}
					$prices['Bitcoin Cash']['change'] = number_format($ticker->change, 2) . '%';
					break;

				case 26:
					$prices['OmiseGo']['price']  = number_format($ticker->last_price, 2) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['OmiseGo']['color'] = '#7bb200';
					} else
					{
						$prices['OmiseGo']['color'] = '#ed027b';
					}
					$prices['OmiseGo']['change'] = number_format($ticker->change, 2) . '%';
					break;

				case 29:
					$prices['ZCoin']['price']  = number_format($ticker->last_price, 2) . ' THB';
					if ($ticker->change >= 0)
					{
						$prices['ZCoin']['color'] = '#7bb200';
					} else
					{
						$prices['ZCoin']['color'] = '#ed027b';
					}
					$prices['ZCoin']['change'] = number_format($ticker->change, 2) . '%';
					break;

			}
		}

		$bubble = FlexMessageBuilder::builder()
			->setAltText('Cryptonist Price')
			->setContents(

				BubbleContainerBuilder::builder()
					->setDirection('ltr')
					->setHero(
						ImageComponentBuilder::builder()
							->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/Cryptonist_Banner.png')
							->setSize('full')
							->setAspectRatio('1024:174')
							->setAspectMode('cover')
							->setAction(
								new UriTemplateActionBuilder('Cryptonist', 'https://cryptonist.co/')
							)
					)
					->setBody(
						BoxComponentBuilder::builder()
							->setLayout(ComponentLayout::VERTICAL)
							->setContents([
								SeparatorComponentBuilder::builder()
									->setMargin('none'),
								BoxComponentBuilder::builder()
									->setMargin('xl')
									->setAction(
										new UriTemplateActionBuilder('Bitcoin', 'https://info.binance.com/en/currencies/bitcoin')
									)
									->setLayout(ComponentLayout::HORIZONTAL)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+8.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('Bitcoin')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
											]),
										TextComponentBuilder::builder()
											->setText($prices['Bitcoin']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['Bitcoin']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['Bitcoin']['color'])
									]),

								BoxComponentBuilder::builder()
									->setLayout(ComponentLayout::HORIZONTAL)
									->setMargin('md')
									->setAction(
										new UriTemplateActionBuilder('Ethereum', 'https://info.binance.com/en/currencies/ethereum')
									)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+9.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('Ethereum')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
											]),
										TextComponentBuilder::builder()
											->setText($prices['Ethereum']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['Ethereum']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['Ethereum']['color'])
									]),
								BoxComponentBuilder::builder()
									->setLayout(ComponentLayout::HORIZONTAL)
									->setMargin('md')
									->setAction(
										new UriTemplateActionBuilder('Bitcoin Cash', 'https://info.binance.com/en/currencies/bitcoin-cash-abc')
									)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+10.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('Bitcoin Cash')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
													->setWrap(true)
											]),
										TextComponentBuilder::builder()
											->setText($prices['Bitcoin Cash']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['Bitcoin Cash']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['Bitcoin Cash']['color'])
									]),
								BoxComponentBuilder::builder()
									->setLayout(ComponentLayout::HORIZONTAL)
									->setMargin('md')
									->setAction(
										new UriTemplateActionBuilder('Omise Go', 'https://info.binance.com/en/currencies/omisego')
									)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+11.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('Omise Go')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
											]),
										TextComponentBuilder::builder()
											->setText($prices['OmiseGo']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['OmiseGo']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['OmiseGo']['color'])
									]),
								BoxComponentBuilder::builder()
									->setLayout(ComponentLayout::HORIZONTAL)
									->setMargin('md')
									->setAction(
										new UriTemplateActionBuilder('Ripple', 'https://info.binance.com/en/currencies/ripple')
									)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+12x.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('Ripple')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
											]),
										TextComponentBuilder::builder()
											->setText($prices['Ripple']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['Ripple']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['Ripple']['color'])
									]),
								BoxComponentBuilder::builder()
									->setLayout(ComponentLayout::HORIZONTAL)
									->setMargin('md')
									->setAction(
										new UriTemplateActionBuilder('ZCoin', 'https://info.binance.com/en/currencies/zcoin')
									)
									->setContents([
										BoxComponentBuilder::builder()
											->setLayout(ComponentLayout::VERTICAL)
											->setFlex(3)
											->setContents([
												ImageComponentBuilder::builder()
													->setUrl('https://s3-ap-southeast-1.amazonaws.com/cryptonist/RichMenu_Artboard+13.png')
													->setAlign('center')
													->setSize('xxs'),
												TextComponentBuilder::builder()
													->setText('ZCoin')
													->setMargin('xs')
													->setSize('xxs')
													->setAlign('center')
											]),
										TextComponentBuilder::builder()
											->setText($prices['ZCoin']['price'])
											->setFlex(7)
											->setMargin('xxl')
											->setGravity('center'),
										TextComponentBuilder::builder()
											->setText($prices['ZCoin']['change'])
											->setFlex(3)
											->setGravity('center')
											->setColor($prices['ZCoin']['color'])
									]),
							])
					));

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('q/Bds8sOv3E3oCpUt/nHFxw/2+BlFZA+9JsE6wR9WI5IsJTUfp5JnxFVR72u1rtW1/Ok5Txw8CDA+SgnZw2BYeM40C84LN81S3AanVx+JzaZ39gS1Ym5aDpukigE89e4nuOQacCybEwyKAP+9eXvNQdB04t89/1O/w1cDnyilFU=');
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'a8259507449b790200b74a8cce8c4b5b']);

        $response = $bot->pushMessage('C640588da4778894a346a2c83a89e67eb', $bubble);
    }

    public function Arbitrage()
    {
        $orderbooks = json_decode(Redis::get('orderbook'));
        $forex = Redis::get('THB');
        // dd($orderbooks);
        $worldwide = array();
        $worldwide['btc']['bid']['price'] = null;
        $worldwide['btc']['ask']['price'] = null;
        $worldwide['eth']['bid']['price'] = null;
        $worldwide['eth']['ask']['price'] = null;
        foreach ($orderbooks as $key => $orderbook) {
            if ($worldwide['btc']['bid']['price'] > $orderbook->btcusd->ask || is_null($worldwide['btc']['bid']['price'])) {
                $worldwide['btc']['bid']['price'] = $orderbook->btcusd->ask;
                $worldwide['btc']['bid']['exchange'] = $key;
            }
            if ($worldwide['btc']['ask']['price'] < $orderbook->btcusd->bid || is_null($worldwide['btc']['ask']['price'])) {
                $worldwide['btc']['ask']['price'] = $orderbook->btcusd->bid;
                $worldwide['btc']['ask']['exchange'] = $key;
            }
            if ($worldwide['eth']['bid']['price'] > $orderbook->ethusd->ask || is_null($worldwide['eth']['bid']['price'])) {
                $worldwide['eth']['bid']['price'] = $orderbook->ethusd->ask;
                $worldwide['eth']['bid']['exchange'] = $key;
            }
            if ($worldwide['eth']['ask']['price'] < $orderbook->ethusd->bid || is_null($worldwide['eth']['ask']['price'])) {
                $worldwide['eth']['ask']['price'] = $orderbook->ethusd->bid;
                $worldwide['eth']['ask']['exchange'] = $key;
            }
        }
        // dd($worldwide);
        $worldwide['btc']['profit'] = ($worldwide['btc']['ask']['price'] - $worldwide['btc']['bid']['price'])/$worldwide['btc']['bid']['price']*100;
        $worldwide['eth']['profit'] = ($worldwide['eth']['ask']['price'] - $worldwide['eth']['bid']['price'])/$worldwide['eth']['bid']['price']*100;

        $thailand = array();
        $thailand['btc']['bid']['price'] = null;
        $thailand['btc']['ask']['price'] = null;
        $thailand['eth']['bid']['price'] = null;
        $thailand['eth']['ask']['price'] = null;
        foreach ($orderbooks as $key => $orderbook) {
            $is_thai = (Ticker::where('exchange', $key)->first()->ticker_para == 'thai');
            
            if ($is_thai) {
                if ($thailand['btc']['bid']['price'] > $orderbook->btcusd->ask || is_null($thailand['btc']['bid']['price'])) {
                    $thailand['btc']['bid']['price'] = $orderbook->btcusd->ask;
                    $thailand['btc']['bid']['exchange'] = $key;
                }
                if ($thailand['btc']['ask']['price'] < $orderbook->btcusd->bid || is_null($thailand['btc']['ask']['price'])) {
                    $thailand['btc']['ask']['price'] = $orderbook->btcusd->bid;
                    $thailand['btc']['ask']['exchange'] = $key;
                }
                if ($thailand['eth']['bid']['price'] > $orderbook->ethusd->ask || is_null($thailand['eth']['bid']['price'])) {
                    $thailand['eth']['bid']['price'] = $orderbook->ethusd->ask;
                    $thailand['eth']['bid']['exchange'] = $key;
                }
                if ($thailand['eth']['ask']['price'] < $orderbook->ethusd->bid || is_null($thailand['eth']['ask']['price'])) {
                    $thailand['eth']['ask']['price'] = $orderbook->ethusd->bid;
                    $thailand['eth']['ask']['exchange'] = $key;
                }
            }
        }
        $thailand['btc']['profit'] = ($thailand['btc']['ask']['price'] - $thailand['btc']['bid']['price'])/$thailand['btc']['bid']['price']*100-0.5;
        $thailand['eth']['profit'] = ($thailand['eth']['ask']['price'] - $thailand['eth']['bid']['price'])/$thailand['eth']['bid']['price']*100-0.5;
        // dd($thailand);

        $response = "Arbitrage (ตลาดไทย):";
        $response .= "\r\n• Bitcoin";
        $response .= " ได้กำไร: ". round($thailand['btc']['profit'], 2)."%";
        $response .= "\r\nถูกที่สุดที่ (". $thailand['btc']['bid']['exchange'] ."): ฿".number_format($thailand['btc']['bid']['price']*$forex, 2);
        $response .= "\r\nแพงที่สุดที่ (". $thailand['btc']['ask']['exchange'] ."): ฿".number_format($thailand['btc']['ask']['price']*$forex, 2);
        $response .= "\r\n• Ethereum";
        $response .= " ได้กำไร: ". round($thailand['eth']['profit'], 2)."%";
        $response .= "\r\nถูกที่สุดที่ (". $thailand['eth']['bid']['exchange'] ."): ฿".number_format($thailand['eth']['bid']['price']*$forex, 2);
        $response .= "\r\nแพงที่สุดที่ (". $thailand['eth']['ask']['exchange'] ."): ฿".number_format($thailand['eth']['ask']['price']*$forex, 2);
        $response .= "\r\n_______________________________";
        $response .= "\r\n\r\nArbitrage (ตลาดนอก):";
        $response .= "\r\n• Bitcoin";
        $response .= " ได้กำไร: ". round($worldwide['btc']['profit'], 2)."%";
        $response .= "\r\nถูกที่สุดที่ (". $worldwide['btc']['bid']['exchange'] ."): $".number_format($worldwide['btc']['bid']['price'], 2);
        $response .= "\r\nแพงที่สุดที่ (". $worldwide['btc']['ask']['exchange'] ."): $".number_format($worldwide['btc']['ask']['price'], 2);
        $response .= "\r\n• Ethereum";
        $response .= " ได้กำไร: ". round($worldwide['eth']['profit'], 2)."%";
        $response .= "\r\nถูกที่สุดที่ (". $worldwide['eth']['bid']['exchange'] ."): $".number_format($worldwide['eth']['bid']['price'], 2);
        $response .= "\r\nแพงที่สุดที่ (". $worldwide['eth']['ask']['exchange'] ."): $".number_format($worldwide['eth']['ask']['price'], 2);
        $response .= "\r\n\r\nคำเตือน: ความล่าช้าจากการอนุมัติถอนของบางตลาดและการยืนยันธุรกรรมบน Blockchain อาจทำให้มีความเสี่ยงที่ราคา ณ ตลาดปลายทางตกก่อนเหรียญไปถึงได้ จึงควรทำเมื่อกำไรมี % สูงๆ เท่านั้น";
        $response .= "\r\n\r\nเพิ่มเติม: https://cryptovationx.io";
        $response .= "\r\n\r\n".now();

        Line::pushText('C25cf6c120577cb6086ec575eb40cf6c6', $response);
    }
}
