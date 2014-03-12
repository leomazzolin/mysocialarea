// JavaScript Document
Banner = function (text, id, type)
{
	
	this.canvas  = document.getElementById(id);
	this.context = this.canvas.getContext('2d');
	this.text = text;
	this.type = type;
	this.fontsetting = 'pt Arial';
	this.fontsize = '';
	this.bggradient = '';
	this.fontgradient = '';
	
};

Banner.prototype = {
	
	setFontSize: function()
	{
		
		if (this.type == 'logo')
		{
			this.fontsize = 22;
		}
		if (this.type == 'logo1')
		{
			this.fontsize = 24;
		}
		if(this.type == 'pagetitle')
		{
			this.fontsize = 16;
		}
		if(this.type == 'accordian1')
		{
			this.fontsize = 16;
		}
		if(this.type == 'banner1')
		{
			this.fontsize = 16;
		}	},
	
	setBackground: function()
	{
		if (this.type == 'logo' || this.type == 'logo1' || this.type == 'banner1')
		{
			this.bggradient = this.context.createLinearGradient(0, 0, this.canvas.width, 0, 0, this.canvas.width);
			this.bggradient.addColorStop(0,"gold");
			this.bggradient.addColorStop(1,"white");
			this.context.fillStyle = this.bggradient;
			this.context.fillRect(0,0,this.canvas.width,this.canvas.height);
		}
		if(this.type == 'pagetitle')
		{
			this.bggradient = this.context.createLinearGradient(0, 0, this.canvas.width, 0, 0, this.canvas.width);
			this.bggradient.addColorStop(0,"gold");
			this.bggradient.addColorStop(1,"white");
			this.context.fillStyle = this.bggradient;
			this.context.fillRect(0,0,this.canvas.width,this.canvas.height);

		}
		if(this.type == 'accordian1')
		{
			this.bggradient = this.context.createLinearGradient(0, 0, this.canvas.width, 0, 0, this.canvas.width);
			this.bggradient.addColorStop(0,"lightgrey");
			this.bggradient.addColorStop(1,"white");
			this.context.fillStyle = this.bggradient;
			this.context.fillRect(0,0,this.canvas.width,this.canvas.height);

		}
	},

	setText: function()
	{
		if (this.type == 'logo')
		{
			this.context.font = this.fontsize + this.fontsetting;
			this.context.fillStyle = 'black';
			this.context.strokeStyle = 'black';
			this.context.fillText("MySocialArea.com", 10, this.fontsize+8);
			this.context.strokeText("MySocialArea.com", 10, this.fontsize+8 );
		}
		if (this.type == 'logo1')
		{
			this.context.font = this.fontsize + this.fontsetting;
			this.context.fillStyle = 'black';
			this.context.strokeStyle = 'black';
			//this.context.fillText("MySocialArea.com", 20, this.fontsize+15);
			//this.context.strokeText("MySocialArea.com", 20, this.fontsize+15 );
			this.context.fillText("Overview", 20, 2*(this.fontsize+15));
			this.context.strokeText("Overview", 20, 2*(this.fontsize+15));
		}
		if(this.type == 'pagetitle')
		{
			this.context.font = this.fontsize + this.fontsetting;
			/*
			var gradient = this.context.createLinearGradient(0,0,this.canvas.width,this.canvas.height);
			gradient.addColorStop(0, 'blue');
			gradient.addColorStop('0.25', 'green');
			gradient.addColorStop('0.95', 'red');
			gradient.addColorStop(1, 'black');
			this.context.fillStyle = gradient;
			*/
			this.context.fillStyle = 'black';
			this.context.strokeStyle = 'black';
			this.context.fillText(this.text, 10, (this.canvas.height + this.fontsize)/2);
			this.context.strokeText(this.text, 10, (this.canvas.height + this.fontsize)/2);
		}
		if(this.type == 'accordian1')
		{
			this.context.font = this.fontsize + this.fontsetting;
			this.context.fillStyle = 'black';
			this.context.strokeStyle = 'black';
			this.context.fillText(this.text, 10, this.fontsize+8);
			this.context.strokeText(this.text, 10, this.fontsize+8 );
		}
		if (this.type == 'banner1')
		{
			this.context.font = this.fontsize + this.fontsetting;
			this.context.fillStyle = 'black';
			this.context.strokeStyle = 'black';
			this.context.fillText(this.text, 10, this.fontsize+8);
			this.context.strokeText(this.text, 10, this.fontsize+8 );
		}
	},
	
	render: function()
	{
		this.setFontSize();
		this.setBackground();
		this.setText();
	},
	
};
