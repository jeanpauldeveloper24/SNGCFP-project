import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Setting extends StatefulWidget {
  const Setting({super.key});

  @override
  State<Setting> createState() => _SettingState();
}

class _SettingState extends State<Setting> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  
  // États fictifs pour les switchs
  bool _darkMode = false;
  bool _notificationsEmail = true;
  bool _compactMode = false;

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildSectionHeader("Préférences d'affichage"),
          _buildSettingCard([
            _buildSwitchItem(
              Icons.dark_mode_outlined, 
              "Mode Sombre", 
              "Adapter l'interface pour les environnements sombres", 
              _darkMode, 
              (val) => setState(() => _darkMode = val)
            ),
            const Divider(),
            _buildSwitchItem(
              Icons.view_compact_outlined, 
              "Mode Compact", 
              "Afficher plus de données dans les tableaux", 
              _compactMode, 
              (val) => setState(() => _compactMode = val)
            ),
          ]),

          const SizedBox(height: 30),

          _buildSectionHeader("Notifications & Alertes"),
          _buildSettingCard([
            _buildSwitchItem(
              Icons.email_outlined, 
              "Alertes Email", 
              "Recevoir un rapport hebdomadaire des projets", 
              _notificationsEmail, 
              (val) => setState(() => _notificationsEmail = val)
            ),
            const Divider(),
            _buildActionItem(
              Icons.notifications_active_outlined, 
              "Configuration des seuils", 
              "Définir quand une alerte de budget doit être déclenchée",
              () {}
            ),
          ]),

          const SizedBox(height: 30),

          _buildSectionHeader("Sécurité"),
          _buildSettingCard([
            _buildActionItem(
              Icons.lock_reset_outlined, 
              "Changer le mot de passe", 
              "Dernière modification il y a 3 mois", 
              () {}
            ),
            const Divider(),
            _buildActionItem(
              Icons.phonelink_lock_outlined, 
              "Double authentification", 
              "Renforcer la sécurité de votre accès BAD", 
              () {}
            ),
          ]),
        ],
      ),
    );
  }

  Widget _buildSectionHeader(String title) {
    return Padding(
      padding: const EdgeInsets.only(left: 5, bottom: 10),
      child: Text(
        title.toUpperCase(),
        style: GoogleFonts.montserrat(
          fontSize: 13, 
          fontWeight: FontWeight.bold, 
          color: Colors.grey[600],
          letterSpacing: 1.1
        ),
      ),
    );
  }

  Widget _buildSettingCard(List<Widget> children) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.black12),
      ),
      child: Column(children: children),
    );
  }

  Widget _buildSwitchItem(IconData icon, String title, String subtitle, bool value, Function(bool) onChanged) {
    return ListTile(
      leading: Icon(icon, color: primaryBlue),
      title: Text(title, style: GoogleFonts.inter(fontWeight: FontWeight.w600)),
      subtitle: Text(subtitle, style: GoogleFonts.inter(fontSize: 12)),
      trailing: Switch(
        value: value,
        onChanged: onChanged,
        activeColor: primaryBlue,
      ),
    );
  }

  Widget _buildActionItem(IconData icon, String title, String subtitle, VoidCallback onTap) {
    return ListTile(
      onTap: onTap,
      leading: Icon(icon, color: primaryBlue),
      title: Text(title, style: GoogleFonts.inter(fontWeight: FontWeight.w600)),
      subtitle: Text(subtitle, style: GoogleFonts.inter(fontSize: 12)),
      trailing: const Icon(Icons.chevron_right, size: 20),
    );
  }
}