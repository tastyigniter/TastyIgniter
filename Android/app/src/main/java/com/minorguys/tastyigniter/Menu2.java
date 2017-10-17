package com.minorguys.tastyigniter;


import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

/**
 * Created by hp-u on 17-09-2017.
 */

public class Menu2 extends Fragment
{
Button btn1,loginImageBttn;
    EditText id1,pwd1;
    String id,pwd;
    TextView xyz;
    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState)
    {
        super.onViewCreated(view, savedInstanceState);

      //  xyz=(TextView)view.findViewById(R.id.guest);
        btn1=(Button)view.findViewById(R.id.btn1);
         id1=((EditText)view.findViewById(R.id.id));
         pwd1=((EditText)view.findViewById(R.id.pwd));
        btn1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                submit(v);
            }

        });
        getActivity().setTitle("Login");
        loginImageBttn=(Button)view.findViewById(R.id.loginImageBttn);
        loginImageBttn.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                Intent i =new Intent(getActivity(),FaceVerificationActivity.class);
                startActivityForResult(i,10);
            }
        });

    }
    public void submit(View v)
    {
         id=id1.getText().toString();
         pwd=pwd1.getText().toString();
        if(!validate())
            return;
        ConnectToServer();



    }
    private void ConnectToServer(){

        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/login.php".concat("?email="+id+"&password="+pwd),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONObject x = new JSONObject(response);
                            String message=x.getString("message");
                            if(message.equals("Success"))
                            {
                                Toast.makeText(getActivity(), "Login Successfull... Welcome Mr. "+x.getString("fname")+x.getString("lname"), Toast.LENGTH_LONG).show();


                                view(id);
                            }
                            else
                                Toast.makeText(getActivity(), "Invalid Credentials. Try logging in again.", Toast.LENGTH_LONG).show();

                        }




                        catch (Exception e)
                        {
                            Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_SHORT).show();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getActivity(),error.getMessage(),Toast.LENGTH_LONG).show();

                    }
                }){

        };
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity());
        requestQueue.add(stringRequest);
    }
    public boolean validate()
    {

        if(id.equals(""))
            Toast.makeText(getActivity(), "Email id field empty", Toast.LENGTH_SHORT).show();
        else if(!id.endsWith("com"))
            Toast.makeText(getActivity(), "Email Id invalid", Toast.LENGTH_SHORT).show();
        else if(id.indexOf('@')==-1)
            Toast.makeText(getActivity(), "Email Id invalid", Toast.LENGTH_SHORT).show();
        else if(pwd.equals(""))
            Toast.makeText(getActivity(), "Password field empty", Toast.LENGTH_SHORT).show();
        else
            return true;
        return false;
    }



    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState)
    {
        return inflater.inflate(R.layout.login,container,false);
    }
    public void view(String m)
    {
        UserData o=new UserData();
        o.setstatus(true);
        o.setEmail(m);
        o.setPassword(pwd);
    }
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if(requestCode == 10 && resultCode == -1)
        {

            Toast.makeText(getActivity(), "Hi! , You have been Succesfully Logged In.", Toast.LENGTH_SHORT).show();
        }
    }

}
