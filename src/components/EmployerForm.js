import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export default function EmployerForm() {
  const navigate = useNavigate();

  const [employer, setEmployer] = useState({
    companyName: "",
    companyEmail: "",
    companyPhone: "",
    hiringRoleId: "",
    streetAddress: "",
    state: "",
    zipCode: "",
  });

  const roles = {
    0: "Owner",
    1: "CEO",
    2: "Manager",
    3: "Human Resource",
    4: "Hiring Manager",
    5: "Other",
  };

  const roleOption = Object.keys(roles).map((key) => {
    return (
      <option key={key} value={roles[key]}>
        {roles[key]}
      </option>
    );
  });
  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;
    if (name === "hiringRoleId") {
      for (let key of Object.keys(roles)) {
        if (roles[key] === value) {
          setEmployer({ ...employer, [name]: key });
        }
      }
    } else {
      setEmployer({ ...employer, [name]: value });
    }
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    //reset all inputs
    const eInputs = document.querySelector("input");
    for (let i = 0; i < eInputs.length; i++) {
      eInputs[i].value = "";
    }
    axios
      .post("http://localhost:8888/api/user/employerInfo", employer)
      .then(function (response) {
        console.log(response.data);
        navigate("/");
      });
  };

  return (
    <div>
      <h1>Employer Form</h1>
      <form onSubmit={handleSubmit}>
        <table cellSpacing="10">
          <tbody>
            <tr>
              <th>
                <label>Company Name: </label>
              </th>
              <td>
                <input
                  type="text"
                  name="companyName"
                  onChange={handleChange}
                  required
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Company Email: </label>
              </th>
              <td>
                <input
                  type="text"
                  name="companyEmail"
                  placeholder="something@example.com"
                  onChange={handleChange}
                  required
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Company Phone: </label>
              </th>
              <td>
                <input
                  type="tel"
                  name="companyPhone"
                  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                  placeholder="123-456-7889"
                  onChange={handleChange}
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Company Street Address: </label>
              </th>
              <td>
                <input
                  type="tel"
                  name="streetAddress"
                  onChange={handleChange}
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Company State: </label>
              </th>
              <td>
                <input
                  type="text"
                  name="state"
                  placeholder="CA"
                  onChange={handleChange}
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Company ZipCode: </label>
              </th>
              <td>
                <input
                  type="text"
                  name="zipCode"
                  onChange={handleChange}
                />
              </td>
            </tr>
            <tr>
              <th>
                <label>Hiring Role: </label>
              </th>
              <td>
                <select name="hiringRoleId" onChange={handleChange} required>
                  {roleOption}
                </select>
              </td>
            </tr>
            <tr>
              <td colSpan="2" align="right">
                <button>Submit</button>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  );
}
