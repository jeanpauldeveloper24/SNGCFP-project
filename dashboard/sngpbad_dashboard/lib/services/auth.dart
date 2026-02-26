import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';

class AuthService {
  static const String baseUrl = "http://127.0.0.1:8000/api";

  /// Connexion
  Future<UserModel?> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'email': email,
          'password': password,
          'device_name': 'windows_desktop_app',
        }),
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> data = jsonDecode(response.body);
        final userData = data['user'];
        final String token = data['token'];

        final prefs = await SharedPreferences.getInstance();
        
        // --- SAUVEGARDE DES INFOS (Indispensable pour getStoredUser) ---
        await prefs.setString('auth_token', token);
        await prefs.setInt('user_id', userData['id']);
        await prefs.setString('user_name', userData['name']);
        await prefs.setString('user_email', userData['email']);
        await prefs.setString('user_phone', userData['phone'] ?? "");
        
        // On récupère le nom du rôle depuis l'objet role imbriqué
        if (userData['role'] != null) {
          await prefs.setString('user_role', userData['role']['name']);
        }
        
        // On stocke la photo si elle existe
        if (userData['photo'] != null) {
          await prefs.setString('user_photo', userData['photo']);
        }

        return UserModel.fromJson(userData);
      }
      return null;
    } catch (e) {
      print("Erreur Login Service: $e");
      return null;
    }
  }

  /// Inscription 
  Future<bool> register({
    required String name,
    required String email,
    required String phone,
    required String password,
    required String role,
    File? imageFile,
  }) async {
    try {
      var request = http.MultipartRequest('POST', Uri.parse('$baseUrl/register'));
      request.headers.addAll({'Accept': 'application/json'});

      request.fields['name'] = name;
      request.fields['email'] = email;
      request.fields['phone'] = phone;
      request.fields['password'] = password;
      request.fields['role'] = role;

      if (imageFile != null) {
        request.files.add(
          await http.MultipartFile.fromPath('photo', imageFile.path),
        );
      }

      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);

      return response.statusCode == 201 || response.statusCode == 200;
    } catch (e) {
      print("Erreur Register Service: $e");
      return false;
    }
  }

  /// Déconnexion
  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    try {
      await http.post(
        Uri.parse('$baseUrl/logout'),
        headers: {
          'Authorization': 'Bearer $token', 
          'Accept': 'application/json'
        },
      );
    } catch (e) {
      print("Erreur déconnexion: $e");
    } finally {
      await prefs.clear(); // Efface TOUTES les données (ID, Nom, Token)
    }
  }

  /// Mise à jour d'un utilisateur
  Future<bool> updateUser(int id, String name, String phone) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final String? token = prefs.getString('auth_token'); 

      final response = await http.put(
        Uri.parse('$baseUrl/users/$id'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'name': name, 
          'phone': phone
        }),
      );

      if (response.statusCode == 200) {
        await prefs.setString('user_name', name);
        await prefs.setString('user_phone', phone);
        return true;
      }
      return false;
    } catch (e) {
      print("Erreur Update: $e");
      return false;
    }
  }

  /// Récupère les informations stockées (Méthode Statique)
  static Future<Map<String, dynamic>> getStoredUser() async {
    final prefs = await SharedPreferences.getInstance();
    return {
      'id': prefs.getInt('user_id'),
      'name': prefs.getString('user_name') ?? "Utilisateur",
      'email': prefs.getString('user_email') ?? "",
      'phone': prefs.getString('user_phone') ?? "",
      'role_name': prefs.getString('user_role') ?? "Partenaire SNGP",
      'photo': prefs.getString('user_photo'),
    };
  }
}