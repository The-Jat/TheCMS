function BlogList() {
    console.log("Am i loaded?");
  return React.createElement(
    'div',
    null,
    'Blog Plugin Loaded Dynamically 🚀'
  );
}

window.TheCMS.PluginAPI.registerComponent(
  'BlogList',
  BlogList
);

// console.log(
//   'Blog plugin loaded'
// );