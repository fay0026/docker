import { HydraAdmin } from "@api-platform/admin";

const App = () => (
	<HydraAdmin entrypoint={process.env.REACT_APP_API_ENTRYPOINT} />
  );

  export default App;
  