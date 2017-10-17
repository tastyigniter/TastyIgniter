//
// Copyright (c) Microsoft. All rights reserved.
// Licensed under the MIT license.
//
// Microsoft Cognitive Services (formerly Project Oxford): https://www.microsoft.com/cognitive-services
//
// Microsoft Cognitive Services (formerly Project Oxford) GitHub:
// https://github.com/Microsoft/Cognitive-Face-Android
//
// Copyright (c) Microsoft Corporation
// All rights reserved.
//
// MIT License:
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
//
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED ""AS IS"", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
//
package com.minorguys.tastyigniter;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

/**
 * Defined several functions to log service calls.
 */
public class LogHelper {

    // Get all the detection log items.
    public static List<String> getDetectionLog() {
        return mDetectionLog;
    }

    // Add a new detection log item.
    public static void addDetectionLog(String log) {
        mDetectionLog.add(LogHelper.getLogHeader() + log);
    }

    // Clear all detection log items.
    public static void clearDetectionLog() {
        mDetectionLog.clear();
    }

    // Get all the verification log items.
    public static List<String> getVerificationLog() {
        return mVerificationLog;
    }

    // Add a new verification log item.
    public static void addVerificationLog(String log) {
        mVerificationLog.add(LogHelper.getLogHeader() + log);
    }

    // Clear all verification log items.
    public static void clearVerificationLog() {
        mVerificationLog.clear();
    }

    // Get all the grouping log items.
    public static List<String> getGroupingLog() {
        return mGroupingLog;
    }

    // Add a new grouping log item.
    public static void addGroupingLog(String log) {
        mGroupingLog.add(LogHelper.getLogHeader() + log);
    }

    // Clear all grouping log items.
    public static void clearGroupingLog() {
        mGroupingLog.clear();
    }

    // Get all the find similar face log items.
    public static List<String> getFindSimilarFaceLog() {
        return mFindSimilarFaceLog;
    }

    // Add a new find similar face log item.
    public static void addFindSimilarFaceLog(String log) {
        mFindSimilarFaceLog.add(LogHelper.getLogHeader() + log);
    }

    // Clear all find similar face log items.
    public static void clearFindSimilarFaceLog() {
        mFindSimilarFaceLog.clear();
    }

    // Get all the identification log items.
    public static List<String> getIdentificationLog() {
        return mIdentificationLog;
    }

    // Add a new identification log item.
    public static void addIdentificationLog(String log) {
        mIdentificationLog.add(LogHelper.getLogHeader() + log);
    }

    // Clear all identification log items.
    public static void clearIdentificationLog() {
        mIdentificationLog.clear();
    }

    // Detection log items.
    private static List<String> mDetectionLog = new ArrayList<>();

    // Verification log items.
    private static List<String> mVerificationLog = new ArrayList<>();

    // Grouping log items.
    private static List<String> mGroupingLog = new ArrayList<>();

    // Find Similar face log items.
    private static List<String> mFindSimilarFaceLog = new ArrayList<>();

    // Identification log items.
    private static List<String> mIdentificationLog = new ArrayList<>();

    // Get the current time and add to log.
    private static String getLogHeader() {
        DateFormat dateFormat = new SimpleDateFormat("HH:mm:ss", Locale.US);
        return "[" + dateFormat.format(Calendar.getInstance().getTime()) + "] ";
    }
}
