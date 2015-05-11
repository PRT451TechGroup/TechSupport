var Application = new ($Class.define(function()
{
	this.init();
}, function()
{
	this.init = function()
	{
		$(document).delegate("div[data-role=page]", "pageshow", function()
		{
			if ($(this).data("redirect"))
			{
				$(":mobile-pagecontainer").pagecontainer("change", $(this).data("redirect"));
			}
		});
		$(document).delegate("[data-rel=back]", "click", function(e)
		{
			var nb = $(":mobile-pagecontainer").pagecontainer("getActivePage").data("back");

			if (nb)
			{
				e.stopImmediatePropagation();
				e.preventDefault();

				if (nb.length)
					$(":mobile-pagecontainer").pagecontainer("change", nb, {transition: "slide", reverse: true, changeHash: true});
			}
		});
	};
}))();
