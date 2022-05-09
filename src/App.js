import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import "./App.css";
import CreateUser from "./components/CreateUser";
import EditUser from "./components/EditUser";
import EmployerForm from "./components/EmployerForm";

import SignIn from "./components/SignIn";
function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <div className="App-header">
          <img
            className="Logo"
            src={
              window.location.origin + "/logo/Cloud-Jobs-logos_transparent.png"
            }
            alt="App-Logo"
          />

          <nav>
            <ul>
              <li>
                <Link to="/">Search Jobs</Link>
              </li>
              <li>
                <Link to="user/create">My Jobs</Link>
              </li>
            </ul>
          </nav>
        </div>
        <Routes>
          <Route index element={<SignIn />} />
          <Route path="user/create" element={<CreateUser />} />
          <Route path="user/:id/edit" element={<EditUser />} />
          <Route path="user/employerForm" element={<EmployerForm />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}
export default App;
