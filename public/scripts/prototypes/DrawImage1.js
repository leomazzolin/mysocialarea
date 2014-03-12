// JavaScript Document
var DrawImage1 = function (canvas, img)
{
	this.canvasWidth = canvas.width;	
	this.canvasHeight = canvas.height;	
	this.imgWidth = img.width;	
	this.imgHeight = img.height;
	this.rotation = 0;
	this.translateX = 0;
	this.translateY = 0;
	this.imgRatio = img.width/img.height;
	this.canvasRatio = canvas.width/canvas.height;	
};

DrawImage1.prototype = {
	
	getCanvasWidth: function()
	{
		return this.canvasWidth;	
	},
	
	getCanvasHeight: function()
	{
		return this.canvasHeight;
		
	},

	getImageWidth: function()
	{
		return this.imgWidth;	
	},
	
	getimageHeight: function()
	{
		return this.imgHeight;
		
	},
	
	getTranslateX: function()
	{
		return this.translateX;
		
	},

	getTranslateY: function()
	{
		return this.translateY;
		
	},

	getRotation: function()
	{
		return this.rotation;
	},
	
	setRotation: function(r)
	{
		this.rotation = r;
	},

	setCanvasDimensions: function()
	{
		switch(this.rotation)
		{
			case 90:
				if(this.canvasRatio >= 1)
				{
					if (this.imgRatio >= 1)
					{
						this.canvasHeight = this.canvasHeight/this.imgRatio;
					}
					else
					{
						this.canvasWidth = this.canvasWidth*this.imgRatio;
					}
				}
				else
				{
					if (this.imgRatio < 1)
					{
						this.canvasWidth = this.canvasWidth*this.imgRatio;
					}
					else
					{
						this.canvasHeight = this.canvasHeight/this.imgRatio;
					}
				}
			  break;
			case 270:
				if(this.canvasRatio >= 1)
				{
					if (this.imgRatio >= 1)
					{
						this.canvasHeight = this.canvasHeight/this.imgRatio;
					}
					else
					{
						this.canvasWidth = this.canvasWidth*this.imgRatio;
					}
				}
				else
				{
					if (this.imgRatio < 1)
					{
						this.canvasWidth = this.canvasWidth*this.imgRatio;
					}
					else
					{
						this.canvasHeight = this.canvasHeight/this.imgRatio;
					}
				}
			  break;
			case 0, 180:
			  break;
			default:
		}
		this.setTranslation();
	},
	
	setTranslation: function()
	{
		switch(this.rotation)
		{
			case 0:
				this.translateX = (canvas.width - this.canvasWidth)/2;
				this.translateY = (canvas.height - this.canvasHeight)/2;
			  break;
			case 90:
				this.translateX = this.canvasHeight + (canvas.width - this.canvasHeight)/2;
				this.translateY = 0;
			  break;
			case 180:
				this.translateX = this.canvasWidth + (canvas.width - this.canvasWidth)/2;
				this.translateY = this.canvasHeight;
			  break;
			case 270:
				this.translateX = (canvas.width - this.canvasHeight)/2;
				this.translateY = this.canvasWidth + (canvas.height - this.canvasWidth)/2;
			  break;
			default:
		}
	},
};
