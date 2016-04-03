package com.example.phuc9.quanlybo;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

/**
 * Created by phuc9 on 3/20/2016.
 */
public class LoginActivity extends Activity{
    private EditText password;
    protected EditText phonenumber;
    protected String enteredPhonenuber;
    protected String enteredPassword;
    private final String serverUrl = "http://localhost/1.json";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        phonenumber = (EditText)findViewById(R.id.phonenumber);
        password = (EditText)findViewById(R.id.password);
        Button loginButton = (Button)findViewById(R.id.btnLogin);
        loginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                enteredPhonenuber = phonenumber.getText().toString();
                enteredPassword = password.getText().toString();
                if (enteredPhonenuber.equals("") || enteredPassword.equals("")) {
                    Toast.makeText(LoginActivity.this, "Username or password must be filled", Toast.LENGTH_LONG).show();
                    return;
                }
                if (enteredPhonenuber.length() < 8 || enteredPassword.length() < 5) {
                    Toast.makeText(LoginActivity.this, "Username or password must be filled", Toast.LENGTH_LONG).show();
                    return;
                }
            }
            Asy
        });
    }
    @Override
    protected void onPause() {
        super.onPause();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }
}
