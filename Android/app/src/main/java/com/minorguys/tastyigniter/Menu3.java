package com.minorguys.tastyigniter;


import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.UUID;

/**
 * Created by hp-u on 17-09-2017.
 */

public class Menu3 extends Fragment
{  //  UserData userDataVariable = new UserData();

    public static final String TAG = "MAMA";
    private static final int DETECT_IMAGE = 301;

    String fname;
    String lname;
    String answer;
    String pin;
    String state,city ;
    String password, mobile, address1 , address2 , email;
    String country;
    String id;
    String qid;
    String question;
    Spinner q;
    String image_str;
    String uuid_str;
    String data = new String();


    AutoCompleteTextView text;
    ArrayList<String> first = new ArrayList<String>();
    ArrayList<String> second = new ArrayList<String>();
    EditText fn;
    EditText ln;
    EditText em;
    EditText p;
    EditText ct;
    EditText st,ad1,ad2,pt,mo,ans;


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState)
    {
        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("Sign Up");
        text=(AutoCompleteTextView)view.findViewById(R.id.country);
        fn=(EditText)view.findViewById(R.id.fname);
        ln=(EditText)view.findViewById(R.id.lname);
        em=(EditText)view.findViewById(R.id.email);
        q=(Spinner)view.findViewById(R.id.q);
        p=(EditText)view.findViewById(R.id.pin);
        ct=(EditText)view.findViewById(R.id.city);
        st=(EditText)view.findViewById(R.id.state);
        ad1=(EditText)view.findViewById(R.id.add1);
        ad2=(EditText)view.findViewById(R.id.add2);
        pt=(EditText)view.findViewById(R.id.password);
        mo=(EditText)view.findViewById(R.id.mobile);
        ans=(EditText)view.findViewById(R.id.answer);

        Button b=(Button)view.findViewById(R.id.x);
        b.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                submit(v);
            }
        });
        Button setImageBttn = (Button)view.findViewById(R.id.setImageBttn);
        setImageBttn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getActivity(),FaceDetectionActivity2.class);
                startActivityForResult(i,DETECT_IMAGE);
            }
        });
       ConnectToServer2();
        submit2();

    }


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState)
    {
        return inflater.inflate(R.layout.menu3,container,false);
    }
    private void ConnectToServer() throws UnsupportedEncodingException {


        try{
            data = URLEncoder.encode("fname", "UTF-8")
                    + "=" + URLEncoder.encode(fname, "UTF-8");

            data += "&" + URLEncoder.encode("lname", "UTF-8") + "="
                    + URLEncoder.encode(lname, "UTF-8");

            data += "&" + URLEncoder.encode("email", "UTF-8")
                    + "=" + URLEncoder.encode(email, "UTF-8");

            data += "&" + URLEncoder.encode("password", "UTF-8")
                    + "=" + URLEncoder.encode(password, "UTF-8");

            data += "&" + URLEncoder.encode("mobile", "UTF-8") + "="
                    + URLEncoder.encode(mobile, "UTF-8");

            data += "&" + URLEncoder.encode("address1", "UTF-8")
                    + "=" + URLEncoder.encode(address1, "UTF-8");

            data += "&" + URLEncoder.encode("address2", "UTF-8")
                    + "=" + URLEncoder.encode(address2, "UTF-8");
            data += "&" + URLEncoder.encode("city", "UTF-8") + "="
                    + URLEncoder.encode(city, "UTF-8");

            data += "&" + URLEncoder.encode("state", "UTF-8")
                    + "=" + URLEncoder.encode(state, "UTF-8");

            data += "&" + URLEncoder.encode("pin", "UTF-8")
                    + "=" + URLEncoder.encode(pin, "UTF-8");
            data += "&" + URLEncoder.encode("country_id", "UTF-8") + "="
                    + URLEncoder.encode("99", "UTF-8");

            data += "&" + URLEncoder.encode("security_ques_id", "UTF-8")
                    + "=" + URLEncoder.encode("12", "UTF-8");

            data += "&" + URLEncoder.encode("security_ans", "UTF-8")
                    + "=" + URLEncoder.encode(answer, "UTF-8");
            data += "&" + URLEncoder.encode("img", "UTF-8") + "="
                    + URLEncoder.encode(image_str, "UTF-8");
            data += "&" + URLEncoder.encode("uuid_image", "UTF-8") + "="
                    + URLEncoder.encode(uuid_str, "UTF-8");
            Log.d(TAG, "ConnectToServer UUID to be sent: "+uuid_str);

        }
        catch (Exception e)
        {
            Log.d(TAG, "Exception in data string making");
            e.printStackTrace();
        }

        new doConnection().execute();


    }
    public void ConnectToServer2()
    {
        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/country.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0;i<jsonArray.length();i++) {

                                JSONObject jsonObject = jsonArray.getJSONObject(i);

                                first.add(jsonObject.getString("name"));
                            }
                            final String ar[]=first.toArray(new String[first.size()]);

                            ArrayAdapter<String> adapter=new ArrayAdapter<String>(getActivity(),android.R.layout.simple_dropdown_item_1line,ar);

                            text.setThreshold(1);
                            text.setAdapter(adapter);

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
    public void send()
    {
        country=text.getText().toString();
        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/country.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0;i<jsonArray.length();i++) {

                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                if(jsonObject.getString("name").equals(country))
                                {
                                    id=jsonObject.getString("country_id");
                                    break;
                                }

                            }

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
    public void submit2()
    {
        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/security_questions.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0;i<jsonArray.length();i++) {

                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                second.add(jsonObject.getString("question"));

                            }
                            final String ar1[]=second.toArray(new String[second.size()]);



                            q.setAdapter(new ArrayAdapter(getActivity(),android.R.layout.simple_dropdown_item_1line,ar1));


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

    public void send2()
    {
        question=q.getSelectedItem().toString();
        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/security_questions.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0;i<jsonArray.length();i++) {

                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                if(jsonObject.getString("question").equals(question))
                                {
                                    qid=jsonObject.getString("question_id");
                                    break;
                                }

                            }

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
    public void submit(View v)
    {
        initView();

        if(!validate())
          return;

        send();
        send2();
        try {
            ConnectToServer();
        }
        catch(Exception e)
        {
            Log.d(TAG, "COnnect TO Serve Exception");
            e.printStackTrace();
        }


    }
    public boolean validate()
    {
        try{
            if(fname.equals(""))
                Toast.makeText(getActivity(), "First Name field empty", Toast.LENGTH_SHORT).show();
            else if(lname.equals(""))
                Toast.makeText(getActivity(), "Last Name field empty", Toast.LENGTH_SHORT).show();
            else if(email.equals(""))
                Toast.makeText(getActivity(), "Email id field empty", Toast.LENGTH_SHORT).show();
            else if(password.equals(""))
                Toast.makeText(getActivity(), "Password field empty", Toast.LENGTH_SHORT).show();
            else if(mobile.equals(""))
                Toast.makeText(getActivity(), "Mobile field empty", Toast.LENGTH_SHORT).show();
            else if(address1.equals(""))
                Toast.makeText(getActivity(), "Address 1 field empty", Toast.LENGTH_SHORT).show();
            else if(address2.equals(""))
                Toast.makeText(getActivity(), "Address 2 field empty", Toast.LENGTH_SHORT).show();
            else if(city.equals(""))
                Toast.makeText(getActivity(), "City field empty", Toast.LENGTH_SHORT).show();
            else if(state.equals(""))
                Toast.makeText(getActivity(), "State field empty", Toast.LENGTH_SHORT).show();
            else if(pin.equals(""))
                Toast.makeText(getActivity(), "Pin field empty", Toast.LENGTH_SHORT).show();
            else if(answer.equals(""))
                Toast.makeText(getActivity(), "Answer field empty", Toast.LENGTH_SHORT).show();
            else if(!email.endsWith("com"))
                Toast.makeText(getActivity(), "Email Id invalid", Toast.LENGTH_SHORT).show();
            else if(email.indexOf('@')==-1)
                Toast.makeText(getActivity(), "Email Id invalid", Toast.LENGTH_SHORT).show();
            else return true;
        }
        catch(Exception e) {
            Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_SHORT).show();
        }
        return false;


    }
    public void initView()
    {
        fname= fn.getText().toString();
        lname= ln.getText().toString();
        email= em.getText().toString();
        pin= p.getText().toString();
        city= ct.getText().toString();
        state= st.getText().toString();
        address1= ad1.getText().toString();
        address2= ad2.getText().toString();
        password= pt.getText().toString();
        mobile= mo.getText().toString();
        answer=ans.getText().toString();




    }
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if(requestCode == DETECT_IMAGE)
        {
            try{
                image_str= (String)data.getExtras().get("ProfilePhoto");
                UUID eUUID=  (UUID) (data.getExtras().get("UUIDPhoto"));
                uuid_str=eUUID.toString();
                Log.d(TAG, "UUID GOT: "+uuid_str);
                Log.d(TAG, "IMAGE GOT: "+image_str);

            }
            catch(Exception e){
                Log.d(TAG, "HERE is the String Failure"+e.toString());
            }

            //Log.d(TAG, "onActivityResult: "+imageUri.toString().length());
        }
    }
    private class doConnection extends AsyncTask<Void,Void,Void> {
        @Override
        protected Void doInBackground(Void... voids) {

            String text = "";
            BufferedReader reader=null;

            // Send data
            try
            {


                URL url = new URL("http://u1701227.nettech.firm.in/api/signup.php");
                URLConnection conn = url.openConnection();
                conn.setDoOutput(true);
                OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
                wr.write( data );
                wr.flush();

                reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                StringBuilder sb = new StringBuilder();
                String line = null;

                while((line = reader.readLine()) != null)
                {
                    sb.append(line + "\n");
                    Log.d(TAG, "ConnectToServer: "+sb.toString());
                }


                text = sb.toString();
            }
            catch(Exception ex)
            {
                Log.d(TAG, "Exception in url connection");
                ex.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            super.onPostExecute(aVoid);
            Toast.makeText(getActivity(), "Connection to the Server Completed", Toast.LENGTH_SHORT).show();
        }
    }

}
