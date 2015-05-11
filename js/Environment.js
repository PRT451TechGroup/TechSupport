var $Class = new (function()
{
	this.define = function(this_ctor, prototype_ctor)
	{
		prototype_ctor.call(this_ctor.prototype);
		return this_ctor;
	};
	this.property = function(propertyName)
	{
		return (function(val)
		{
			if (typeof val === "undefined")
			{
				return this[propertyName];
			}
			else
			{
				this[propertyName] = val;
				return this;
			}
		});
	};
	
})();
