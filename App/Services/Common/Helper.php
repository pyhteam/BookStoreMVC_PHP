<?php 
namespace App\Services\Common;
 class Helper {
    public static function HashSha128($data) {
        return sha1($data);
    }
    public static function NewGuiId($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    public static  function Slugify($string, $slug = '-', $extra = null) {
		if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
			$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|caron|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
		}
	
		if (preg_match('~[^[:ascii:]]~', $string) > 0) {
			$latin = array(
				'a' => '~[àáảãạăằắẳẵặâầấẩẫậÀÁẢÃẠĂẰẮẲẴẶÂẦẤẨẪẬą]~iu',
				'ae' => '~[ǽǣ]~iu',
				'b' => '~[ɓ]~iu',
				'c' => '~[ćċĉč]~iu',
				'd' => '~[ďḍđɗð]~iu',
				'e' => '~[èéẻẽẹêềếểễệÈÉẺẼẸÊỀẾỂỄỆęǝəɛ]~iu',
				'g' => '~[ġĝǧğģɣ]~iu',
				'h' => '~[ĥḥħ]~iu',
				'i' => '~[ìíỉĩịÌÍỈĨỊıǐĭīįİ]~iu',
				'ij' => '~[ĳ]~iu',
				'j' => '~[ĵ]~iu',
				'k' => '~[ķƙĸ]~iu',
				'l' => '~[ĺļłľŀ]~iu',
				'n' => '~[ŉń̈ňņŋ]~iu',
				'o' => '~[òóỏõọôồốổỗộơờớởỡợÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢǒŏōőǫǿ]~iu',
				'r' => '~[ŕřŗ]~iu',
				's' => '~[ſśŝşșṣ]~iu',
				't' => '~[ťţṭŧ]~iu',
				'u' => '~[ùúủũụưừứửữựÙÚỦŨỤƯỪỨỬỮỰǔŭūűůų]~iu',
				'w' => '~[ẃẁŵẅƿ]~iu',
				'y' => '~[ỳýỷỹỵYỲÝỶỸỴŷȳƴ]~iu',
				'z' => '~[źżžẓ]~iu',
			);
	
			$string = preg_replace($latin, array_keys($latin), $string);
		}
	
		return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']++~i', $slug, $string), $slug));
	}

	// Number to Currency
	public static function  formatCurrencyVND($number)
	{
		// Set locale to Vietnamese
		setlocale(LC_MONETARY, 'vi_VN');
		// Format the number as currency in VND
		$formattedNumber = number_format($number, 0, ',', '.') . ' đ';
		return $formattedNumber;
	}

	// Ramdom String
	public static function randomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
	
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength -1)];
		}
	
		return $randomString;
	}
 }