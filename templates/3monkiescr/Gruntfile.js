module.exports = function(grunt) {
	grunt.initConfig({
		
		
		
		uglify : {
			options : {
				compress:true,
				report:true,
				banner:'/*!<%= grunt.template.date() %> */\n'
			},
			app : {
				files: {
					'js/main.min.js' : [
						'js/main.js'
						
					]
				}
			}
		},
		watch: {
	      
	      /* watch and see if our javascript files change, or new packages are installed */
	      js: {
	        files: ['js/main.js'],
	        tasks: ['uglify']
	      },
	      /* watch our files for change, reload */
	      livereload: {
	        files: ['js/{main.min.js}'],
	        options: {
	          livereload: true
	        }
	      },
	    }


	});

	

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default',['watch']);
};