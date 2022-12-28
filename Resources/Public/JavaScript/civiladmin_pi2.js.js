(function($)
{

	$('span.withSub').bind('click', function () {
		if ($('li.sub_' + $(this).attr('id')).css('display') == 'block') {
			$('li.sub_' + $(this).attr('id')).hide('fast');

			$('span#' + $(this).attr('id') + ' > img').attr("alt", 'Aufklappen');
			$('span#' + $(this).attr('id') + ' > img').attr("title", 'Strukturebene aufklappen');
			$('span#' + $(this).attr('id') + ' > img').attr("class", 'plusInfo closed');
			$('span#' + $(this).attr('id') + ' > img').attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/open-normal.png');

			$(".withSub img.plusInfo").bind('mouseover', function () {
				$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/open-MouseOver.png');
			});
			$(".withSub img.plusInfo").bind('mouseout', function () {
				$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/open-normal.png');
			});

		}
		else {
			$('li.sub_o_' + $(this).attr('id')).css({display: 'block'});

			$('span#' + $(this).attr('id') + ' > img').attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/close-normal.png');
			$('span#' + $(this).attr('id') + ' > img').attr("alt", 'Zuklappen');
			$('span#' + $(this).attr('id') + ' > img').attr("title", 'Strukturebene zuklappen');
			$('span#' + $(this).attr('id') + ' > img').attr("class", 'minusInfo open');

			$(".withSub img.minusInfo").bind('mouseover', function () {
				$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/close-MouseOver.png');
			});
			$(".withSub img.minusInfo").bind('mouseout', function () {
				$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/close-normal.png');
			});

		}

		return false;

	});
	$(".withSub img.minusInfo").bind('mouseover', function () {
		$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/close-MouseOver.png');
	});
	$(".withSub img.minusInfo").bind('mouseout', function () {
		$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/close-normal.png');
	});
	$(".withSub img.plusInfo").bind('mouseover', function () {
		$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/open-MouseOver.png');
	});
	$(".withSub img.plusInfo").bind('mouseout', function () {
		$(this).attr("src", '/typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/open-normal.png');
	});
	
	
}(jQuery));