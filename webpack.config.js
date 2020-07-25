////////////////////////////////////////////////////////////////////////////////////////////////////
//// IMPORTS
////////////////////////////////////////////////////////////////////////////////////////////////////
const { resolve } = require("path");
const ManifestPlugin = require("webpack-manifest-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const envLoaded = require("dotenv").load();



////////////////////////////////////////////////////////////////////////////////////////////////////
//// BASE DEFINITIONS
////////////////////////////////////////////////////////////////////////////////////////////////////
if(envLoaded.error)
	throw new Error("failed to load .env file");

const mode = process.env["NODE_ENV"];
const dev = (mode === "development");
const config = {
	resolve: {
		alias: {},
		extensions: []
	},
	entry: {},
	output: {},
	module: {
		rules: []
	},
	plugins: [],
	mode,
};

const path = src => resolve(__dirname, src);
const styleLoaders = ["style-loader", "css-loader"];
const sassLoaders = [...styleLoaders, "sass-loader"];
const libraries = /(node_module|bower_component)s/gi;



////////////////////////////////////////////////////////////////////////////////////////////////////
//// TARGET
////////////////////////////////////////////////////////////////////////////////////////////////////
config.target = "web";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// MODULE RESOLUTION
////////////////////////////////////////////////////////////////////////////////////////////////////
config.resolve.alias["@js"] = path("dev/js/");
config.resolve.alias["@tests"] = path("dev/js/tests/");
config.resolve.alias["@e2e"] = path("dev/js/e2e/");

config.resolve.alias["@vue"] = path("dev/vue/");
config.resolve.alias["@components"] = path("dev/vue/components/");
config.resolve.alias["@vplugins"] = path("dev/vue/plugins/");

config.resolve.alias["@css"] = path("dev/sass/");
config.resolve.alias["@img"] = path("dev/resources/img/");

config.resolve.alias["$vue"] = "vue/dist/vue.esm.js";
config.resolve.alias["$mvue"] = "vue/dist/vue.min.js";
config.resolve.alias["$localStorage"] = "store";

config.resolve.extensions = [
	"js",
	"vue",
	"scss",
	"css"
].map(ext => `.${ext}`);



////////////////////////////////////////////////////////////////////////////////////////////////////
//// ENTRIES
////////////////////////////////////////////////////////////////////////////////////////////////////
config.entry["home"] = "@js/home.js";
//auth
config.entry["login"] = "@js/auth/login.js";
config.entry["register"] = "@js/auth/register.js";

//admin
config.entry["admin/dashboard"] = "@js/admin/dashboard.js";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// OUTPUTS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.output["path"] = path("public_html/assets/js/");
config.output["filename"] = dev ? "[name].bundle.js" : "[name].[chunkhash:8].bundle.js";
config.output["publicPath"] = "/assets/js/";
config.output["chunkFilename"] = "[name].chunk.js";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// DEV TOOLS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.devtool = dev ? "cheap-module-eval-source-map" : false;



////////////////////////////////////////////////////////////////////////////////////////////////////
//// MODULES/LOADERS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.module.rules.push({
	test: /\.js$/i,
	exclude: libraries,
	use: [
		"babel-loader"
	]
});

config.module.rules.push({
	test: /\.(png|jpe?g|gif|svg)$/i,
	exclude: libraries,
	use: [
		{
			loader: "url-loader",
			options: {
				limit: 8192,
				name: "[name].[hash:8].[ext]"
			}
		},
		{
			loader: "img-loader",
			options: {
				enabled: !dev
			}
		}
	]
});

config.module.rules.push({
	test: /\.(woff2?|eot|ttf|otf)$/i,
	loader: "file-loader"
});

config.module.rules.push({
    test: /\.css$/i,
    use: styleLoaders
});

config.module.rules.push({
	test: /\.s[ac]ss$/i,
	use: sassLoaders
});

config.module.rules.push({
	test: /\.vue$/i,
	loader: "vue-loader",
    options: {
		loaders: {
			css: `vue-style-loader${sassLoaders.map(e=>`!${e}`).join("")}`,
			scss: `vue-style-loader${sassLoaders.map(e=>`!${e}`).join("")}`,
			sass: `vue-style-loader${sassLoaders.map(e=>`!${e}`).join("")}`,
		}
	}
});



////////////////////////////////////////////////////////////////////////////////////////////////////
//// PLUGINS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.plugins.push(new VueLoaderPlugin());
if(!dev){
	config.plugins.push(new CleanWebpackPlugin(["assets/js"], {
		root: path("public_html/"),
		verbose: true,
		dry: false,
        exclude: ["globals", "globals/*", "globals/*.*"]
	}));
}
config.plugins.push(new ManifestPlugin());



////////////////////////////////////////////////////////////////////////////////////////////////////
//// EXPORT
////////////////////////////////////////////////////////////////////////////////////////////////////
module.exports = config;
