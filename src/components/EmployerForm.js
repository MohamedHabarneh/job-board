import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";


export default function EmployerForm() {
    const navigate = useNavigate();

    const[employer,setEmployer] = useState({companyName:'',companyEmail:'',companyPhone:'',streetAddress:'',state:'',zipCode:'' })

    const handleChange = (e) =>{
        const name = e.target.name;
        const value = e.target.value;
        setEmployer({...employer,[name]:value})

    }
    
    const handleSubmit = (event) => {
      event.preventDefault();
      
      //reset all inputs
        const eInputs = document.querySelector('input')
        for(let i =0; i<eInputs.length;i++){
            eInputs[i].value = '';
        }
        console.log(employer)
      axios
        .post("http://localhost:8888/api/user/employerInfo", employer)
        .then(function (response) {
          console.log(response.data);
          navigate("/");
        });
    };

    const handleClear = (e) =>{
        e.preventDefault();

        const companyName = document.getElementById('companyName')
        companyName.value = '';
    }
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
                  <input type="text" name="companyName" onChange={handleChange} required />
                </td>
              </tr>
              <tr>
                <th>
                  <label>Company Email: </label>
                </th>
                <td>
                  <input type="text" name="companyEmail" placeholder="something@example.com" onChange={handleChange} required/>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Company Phone: </label>
                </th>
                <td>
                  <input type="tel" name="companyPhone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7889" onChange={handleChange} required/>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Company Street Address: </label>
                </th>
                <td>
                  <input type="tel" name="streetAddres" onChange={handleChange} required />
                </td>
              </tr>
              <tr>
                <th>
                  <label>Company State: </label>
                </th>
                <td>
                  <input type="text" name="state"  placeholder="CA" onChange={handleChange} required />
                </td>
                </tr>
                <tr>
                <th>
                  <label>Company ZipCode: </label>
                </th>
                <td>
                  <input type="text" name="zipCode" onChange={handleChange} required />
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