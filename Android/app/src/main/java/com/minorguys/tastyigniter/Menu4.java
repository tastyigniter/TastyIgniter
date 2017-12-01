package com.minorguys.tastyigniter;


import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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
 * Created by arpit on 28/9/17.
 */

public class Menu4 extends Fragment
{
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
    TextView fn;
    String cid;
    TextView ln;
    TextView em,p,ct, st,ad1,ad2,mo;
   TextView text;


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("Profile");
        text=(TextView)view.findViewById(R.id.country);
        fn=(TextView) view.findViewById(R.id.fname);
        ln=(TextView) view.findViewById(R.id.lname);
        em=(TextView) view.findViewById(R.id.email);
        p=(TextView) view.findViewById(R.id.pin);
        ct=(TextView) view.findViewById(R.id.city);
        st=(TextView) view.findViewById(R.id.state);
        ad1=(TextView) view.findViewById(R.id.add1);
        ad2=(TextView) view.findViewById(R.id.add2);
        mo=(TextView) view.findViewById(R.id.mobile);


        UserData o=new UserData();

        if(o.getstatus() && !(o.getFname().equals(""))){
            Log.d("MAMA", "Sahi if Mei Ghusa Hai: ");
            fn.setText(o.getFname());
            ln.setText(o.getLname());
            p.setText(o.getPin());
            em.setText(o.getEmail());
            ct.setText(o.getCity());
            st.setText(o.getState());
            mo.setText(o.getMobile());
            ad1.setText(o.getAddress1());
            ad2.setText(o.getAddress2());
            text.setText(o.getCountry());

            //Toast.makeText(getActivity(), ""+cid, Toast.LENGTH_SHORT).show();
        }
        else if(o.getstatus())
        {   id=o.getEmail();
            password=o.getPassword();
            send();
        }
        else{
            Toast.makeText(getActivity(), "Not Logged in", Toast.LENGTH_SHORT).show();

        }


    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState)
    {
        return inflater.inflate(R.layout.profile,container,false);
    }
    public void send()
    {

        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/login.php".concat("?email="+id+"&password="+password),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONObject x = new JSONObject(response);
                            fname=x.getString("fname");
                            lname=x.getString("lname");
                            pin=x.getString("pin");
                           // email=x.getString("email");
                            city=x.getString("city");
                            state=x.getString("state");
                            mobile=x.getString("mobile");
                            address1=x.getString("address1");
                            address2=x.getString("address2");
                            country=x.getString("country_name");
                            String message=x.getString("message");


                            if(message.equals("Success"))
                            {
                                fn.setText(fname);
                                ln.setText(lname);
                                p.setText(pin);
                                em.setText(id);
                                ct.setText(city);
                                st.setText(state);
                                mo.setText(mobile);
                                ad1.setText(address1);
                                ad2.setText(address2);
                                text.setText(country);
                                cid=x.getString("cust_id");
                                UserData o=new UserData();
                                o.setId(cid);
                               //Toast.makeText(getActivity(), "Login Successfull... Welcome Mr. "+x.getString("fname")+" "+x.getString("lname"), Toast.LENGTH_LONG).show();
                                //view(id);
                            }
                            else
                                Toast.makeText(getActivity(), "Login Failure", Toast.LENGTH_LONG).show();

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



}




