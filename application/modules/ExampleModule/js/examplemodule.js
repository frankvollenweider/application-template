(function($) {
    Tc.Module.Examplemodule = Tc.Module.extend({

        on: function(callback) {

            var that = this;
            var $ctx = this.$ctx;

            callback();

        },

        after: function() {

        }

    });
})(Tc.$);
