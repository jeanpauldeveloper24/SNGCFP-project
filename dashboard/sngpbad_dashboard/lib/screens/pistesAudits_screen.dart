import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class PistesAuditsScreen extends StatefulWidget {
  const PistesAuditsScreen({super.key});

  @override
  State<PistesAuditsScreen> createState() => _PistesAuditsScreenState();
}

class _PistesAuditsScreenState extends State<PistesAuditsScreen> {
  // Liste simulée basée STRICTEMENT sur ton dictionnaire de données Firebase
  final List<Map<String, dynamic>> _auditsLog = [
    {
      "action": "VALIDATION_VISA_FISCAL",
      "datetime": "26/05/2026 14:32:10",
      "project_id": "PRJ-BOUNDIALI-2026",
      "user_name": "Mme. Traoré (Contrôleur Fisc)",
    },
    {
      "action": "DECAISSEMENT_FONDS_EFFECTUE",
      "datetime": "26/05/2026 11:15:04",
      "project_id": "SNGCFP-PROJECT",
      "user_name": "Jean-Pierre Dupuis (BAD)",
    },
    {
      "action": "BLOCAGE_MAIN_LEVEE",
      "datetime": "25/05/2026 17:45:22",
      "project_id": "PRJ-BASSAM-M2",
      "user_name": "Cabinet du Ministre",
    },
    {
      "action": "CONNEXION_REFUSEE",
      "datetime": "24/05/2026 09:00:15",
      "project_id": "SYSTEM_GLOBAL",
      "user_name": "Utilisateur Inconnu",
    }
  ];

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFE74C3C);
  final Color textDark = const Color(0xFF1E1E2D);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F6F9),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 24),
            _buildSecurityOverview(),
            const SizedBox(height: 24),
            Expanded(
              child: Container(
                width: double.infinity,
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
                  border: Border.all(color: Colors.grey.withOpacity(0.1)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildTableToolbar(),
                    Expanded(
                      child: _auditsLog.isEmpty
                          ? _buildEmptyState()
                          : ListView.separated(
                              itemCount: _auditsLog.length,
                              separatorBuilder: (context, index) => const Divider(height: 1, color: Color(0xFFF1F1F1)),
                              itemBuilder: (context, index) {
                                final log = _auditsLog[index];
                                return _buildAuditLogItem(log);
                              },
                            ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Pistes d'Audits & Traçabilité",
          style: GoogleFonts.montserrat(fontSize: 26, fontWeight: FontWeight.bold, color: textDark),
        ),
        const SizedBox(height: 4),
        Text(
          "Historique immuable des actions et modifications du dictionnaire de données",
          style: GoogleFonts.inter(fontSize: 13, color: Colors.grey[600]),
        ),
      ],
    );
  }

  Widget _buildSecurityOverview() {
    return Row(
      children: [
        _buildSecurityCard("Intégrité des Logs", "Sécurisé", "Aucune altération", Icons.verified_shield_rounded, Colors.green),
        const SizedBox(width: 16),
        _buildSecurityCard("Événements Enregistrés", "${_auditsLog.length} actions", "Total historique", Icons.history_toggle_off_rounded, primaryBlue),
      ],
    );
  }

  Widget _buildSecurityCard(String title, String value, String desc, IconData icon, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(8),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.01), blurRadius: 6)],
          border: Border.all(color: Colors.grey.withOpacity(0.05)),
        ),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(color: color.withOpacity(0.1), borderRadius: BorderRadius.circular(8)),
              child: Icon(icon, color: color, size: 24),
            ),
            const SizedBox(width: 16),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: GoogleFonts.inter(fontSize: 11, color: Colors.grey, fontWeight: FontWeight.w500)),
                const SizedBox(height: 2),
                Text(value, style: GoogleFonts.inter(fontSize: 16, fontWeight: FontWeight.bold, color: textDark)),
                Text(desc, style: GoogleFonts.inter(fontSize: 11, color: Colors.grey[500])),
              ],
            )
          ],
        ),
      ),
    );
  }

  Widget _buildTableToolbar() {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            "Journal de traçabilité des utilisateurs",
            style: GoogleFonts.montserrat(fontSize: 14, fontWeight: FontWeight.bold, color: textDark),
          ),
          IconButton(
            onPressed: () {},
            icon: Icon(Icons.refresh_rounded, color: primaryBlue),
            tooltip: "Actualiser le journal",
          )
        ],
      ),
    );
  }

  // Composant graphique unitaire généré à partir de tes clés JSON exactes
  Widget _buildAuditLogItem(Map<String, dynamic> log) {
    // Extraction sécurisée des données
    final String action = log["action"] ?? "ACTION_INCONNUE";
    final String datetime = log["datetime"] ?? "—";
    final String projectId = log["project_id"] ?? "GÉNÉRAL";
    final String userName = log["user_name"] ?? "Utilisateur Système";

    // Logique de couleur dynamique intelligente pour la charte graphique
    Color badgeColor = primaryBlue;
    IconData logIcon = Icons.info_outline_rounded;

    if (action.contains('BLOQUE') || action.contains('REFUSE') || action.contains('REJETE') || action.contains('REFUSEE')) {
      badgeColor = errorRed;
      logIcon = Icons.gpp_bad_rounded;
    } else if (action.contains('EFFECTUE') || action.contains('VALIDE')) {
      badgeColor = Colors.green;
      logIcon = Icons.check_circle_outline_rounded;
    }

    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Horodatage (Clé: datetime)
          SizedBox(
            width: 160,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  datetime,
                  style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.w600, color: textDark),
                ),
                const SizedBox(height: 2),
                Text(
                  "Enregistré",
                  style: GoogleFonts.inter(fontSize: 11, color: Colors.grey),
                ),
              ],
            ),
          ),
          
          // Indicateur Visuel de Sévérité
          Icon(logIcon, color: badgeColor, size: 20),
          const SizedBox(width: 16),

          // Contenu principal (Clés: action, project_id, user_name)
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                      decoration: BoxDecoration(
                        color: badgeColor.withOpacity(0.08),
                        borderRadius: BorderRadius.circular(4),
                        border: Border.all(color: badgeColor.withOpacity(0.2)),
                      ),
                      child: Text(
                        action,
                        style: GoogleFonts.inter(
                          color: badgeColor, 
                          fontSize: 11, 
                          fontWeight: FontWeight.bold,
                          letterSpacing: 0.3
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Text(
                      "Projet : $projectId",
                      style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.bold, color: primaryBlue),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                Row(
                  children: [
                    Text(
                      "Action déclenchée par : ",
                      style: GoogleFonts.inter(fontSize: 12, color: Colors.grey[600]),
                    ),
                    Text(
                      userName,
                      style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.w600, color: textDark),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.security_update_good_rounded, size: 48, color: Colors.grey[400]),
          const SizedBox(height: 16),
          Text(
            "Aucun log d'audit disponible",
            style: GoogleFonts.montserrat(fontSize: 14, fontWeight: FontWeight.bold, color: Colors.grey),
          ),
        ],
      ),
    );
  }
}