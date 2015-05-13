var Application = new ($Class.define(function()
{
	this.init();
}, function()
{
	this.init = function()
	{
		$(document).delegate("div[data-role=page][data-redirect]", "pageshow", function()
		{
			$(":mobile-pagecontainer").pagecontainer("change", $(this).data("redirect"));
			
		});
		$(document).delegate("div[data-role=page][data-force-refresh=true]", "pageshow", function()
		{
			$(this).trigger("create");
			$(this).find("[data-role=listview]").listview("refresh");
		});
		$(document).delegate("select[name=completion]", "change", function()
		{
			var $this = $(this);
			var $val = $this.val();
			var themes = "cdefg";
			var rep = $("<select />");
			rep.attr("name", "completion");
			rep.attr("data-theme", themes[$val]);

			$.each($this.find("option"), function(k, v)
			{
				var $v = $(v);
				var opt = $("<option />");
				opt.attr("value", $v.attr("value"));
				if ($val == $v.attr("value"))
				{
					opt.attr("selected", "selected");
				}
				
				opt.text($v.text());
				rep.append(opt);
			});
			//rep.val($val);

			//alert($this.parent().parent().parent().prop("tagName"));
			var parent = $this;
			while((parent = parent.parent()).prop("tagName") != "LI") { if (!parent) break; };
			parent.append(rep);
			$this.remove();
			rep.trigger("create");
			rep.selectmenu();
			
			
			$("[data-role=listview]").listview("refresh");
		});

		/*$(document).on("pagecontainerhide", function(event, ui)
		{
			var redirect = ui.toPage.data("redirect");
			if (redirect)
			{
				event.preventDefault();
				$(":mobile-pagecontainer").pagecontainer("change", redirect, {transition: "slide"});
			}
		});*/
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
